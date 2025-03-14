<?php

namespace App\Http\Controllers\CMS;

use App\InformationBlock;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use Illuminate\Http\Request;

use Imageupload;

class ProductsController extends CMSController
{
  public function index()
  {
    return view('cms.products.index', ['data' => Product::orderBy('model')->get()]);
  }

  public function create()
  {
    $brakes = Product::brakes();
    $categories = Product::categories();
    $engines = Product::engines();
    $tires = Product::tires();
    $data = NULL;
    return view('cms.products.form', compact('brakes', 'categories', 'data', 'engines', 'tires'));
  }

  public function store(Request $request)
  {
    $this->check($request);

    $data = Product::create($this->getParams($request));

    $this->save_product_colors($request, $data);
    $this->save_descriptions($request, $data);
    $this->upload($request, $data);

    return redirect('cms/products')->with('success', "El producto fué agregado correctamente.");
  }

  public function edit($id)
  {
    $data = Product::find($id);

    if ($data == NULL) return redirect('cms/products')->with('error', "El producto no existe.");

    $brakes = Product::brakes();
    $categories = Product::categories();
    $engines = Product::engines();
    $tires = Product::tires();

    return view('cms.products.form', compact('data', 'brakes', 'categories', 'engines', 'tires'));
  }

  public function update(Request $request, $id)
  {
    $this->check($request);

    $data = Product::find($id);

    $data->update($this->getParams($request));

    foreach (['header_image_mobile', 'header_image', 'product_logo', 'pdf'] as $key) :
      if ($request->get("_destroy_$key") == "true" && $data->$key != NULL && file_exists($data->$key)) {
        parent::delete_file($data->$key);
        $data->$key = NULL;
      }
    endforeach;

    $this->save_product_colors($request, $data);
    $this->save_descriptions($request, $data);
    $this->upload($request, $data);

    $data->save();

    return redirect('cms/products')->with('success', "El producto fue actualizado correctamente.");
  }

  public function destroy($id)
  {
    $data = Product::find($id);

    foreach ([
      $data->images(),
      $data->colors(),
      $data->descriptions()
    ] as $arr) :
      foreach ($arr as $row) :
        parent::delete_file($row->image);
        $row->delete();
      endforeach;
    endforeach;

    parent::delete_file($data->header_image);
    parent::delete_file($data->header_image);
    parent::delete_file($data->product_logo);
    parent::delete_file($data->description_image);

    $data->delete();

    return redirect('cms/products')->with('success', "El producto fue eliminado correctamente.");
  }

  public function import(Request $request)
  {
    switch ($request->get('type')) {
      case 'product':
        $this->import_products($request);
        break;
      case 'pricing':
        $this->import_pricing($request);
        break;
    }

    return view('cms.products.import');
  }


  public function import_pricing(Request $request)
  {
    $data = json_decode($request->get('data'), true);

    if ($data == NULL || $data == '') {
      return view('cms.products.import');
    }

    if (!is_array($data)) {
      return redirect('cms/products/import')->with('error', "No se pudieron leer los precios.");
    }

    foreach ($data as $model => $row) :
      try {
        $product = Product::where('model', '=', $model)->first();
        if ($product) {
          $product->pricing = json_encode($row);
          $product->active = $row[3]['value'];
          $product->save();
          // dd(json_encode($row));
        }
      } catch (Exception $e) {
      }
    endforeach;

    return redirect('cms/products')->with('success', "Los precios se importaron correctamente");
  }

  public function import_products(Request $request)
  {
    $data = json_decode($request->get('data'), true);

    if ($data == NULL || $data == '') {
      return view('cms.products.import');
    }

    if (!is_array($data)) {
      return redirect('cms/products/import')->with('error', "No se pudieron leer los productos.");
    }

    foreach ($data as $model => $row) :
      try {
        $product = Product::where('model', '=', $model)->first();
        $product->category = $row['category'];
        $product->specs = json_encode($row['specs']);
        $product->save();
      } catch (Exception $e) {
        Product::create([
          'model' => $model,
          'category' => $row['category'],
          'specs' => json_encode($row['specs']),
        ])->save();
      }
    endforeach;

    return redirect('cms/products')->with('success', "Los productos se importaron correctamente");
  }

  private function getParams(Request $request)
  {
    $result = ['order' => 0];
    $permit = [
      'active',
      'category',
      'code',
      'financing_requirements',
      'header_image',
      'header_image_mobile',
      'intro',
      'model',
      'order',
      'pdf',
      'pricing',
      'product_logo',
      'specs',
      'spot_price',
    ];

    foreach ($permit as $field) :
      if ($request->get($field) == NULL) continue;
      $result[$field] = $request->get($field);
    endforeach;

    if (key_exists('video', $result) && $result['video'] != NULL) {
      $result['video'] = $this->videoURLCorrection($result['video']);
    }

    $result['active'] = $request->get('active') === "true";

    return $result;
  }

  private function check(Request $request)
  {
    $request->validate([
      'model' => 'required|string|max:255',
      'intro' => 'required|string|max:255',
    ]);
  }

  private function videoURLCorrection($url)
  {
    return strtr($url, ['/watch?v=' => '/embed/']);
  }

  private function upload(Request $request, Product $data)
  {
    if ($request->hasFile('header_image_mobile')) {
      parent::delete_file($data->header_image_mobile);
      $data->header_image_mobile = parent::file_upload($request->header_image_mobile, "products/{$data->id}_header_mobile");
    }

    if ($request->hasFile('header_image')) {
      parent::delete_file($data->header_image);
      $data->header_image = parent::file_upload($request->header_image, "products/{$data->id}_header");
    }

    if ($request->hasFile('product_logo')) {
      parent::delete_file($data->product_logo);
      $result = Imageupload::upload($request->file('product_logo'));
      $data->product_logo = parent::file_upload($result['dimensions']['size280x78']['filepath'], "products/{$data->id}_logo");
      $this->clearResult($result);
    }

    if ($request->hasFile('pdf') && $request->file('pdf')->getMimeType() == 'application/pdf') {
      parent::delete_file($data->pdf);
      $pdf = 'uploads/products/' . $data->id . '.pdf';
      copy($request->file('pdf')->getRealPath(), $pdf);
      $data->pdf = $pdf;
    }

    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $row) :
        $image = ProductImage::create([
          'product_id' => $data->id,
          'image' => ''
        ]);

        $image->image = parent::file_upload($row, "product_images/{$image->id}_logo");
        $image->save();
      endforeach;
    }

    $data->save();
  }

  private function save_product_colors(Request $request, Product $product)
  {
    if (!isset($request['product_colors_attributes'])) return;
    foreach ($request['product_colors_attributes'] as $i => $row) :
      if (isset($row['id']) && $row['id'] > 0) {
        $data = ProductColor::find($row['id']);
        if (isset($data)) {
          if (isset($row['_destroy']) && $row['_destroy'] == "true") {
            parent::delete_file($data->image);
            $data->delete();
            continue;
          } else {
            if (isset($row['_destroy_image']) && $row['_destroy_image'] == "true") {
              parent::delete_file($data->image);
              $data->image = NULL;
            }
            $data->color = $row['color'];
          }
        }
      } else {
        $data = ProductColor::create([
          'product_id' => $product->id,
          'color' => $row['color'],
          'image' => ''
        ]);;
      }

      if (isset($row['image'])) {
        parent::delete_file($data->image);
        $result = Imageupload::upload($row['image']);
        $data->image = parent::file_upload($result['dimensions']['square720']['filepath'], "product_colors/{$data->id}");
      }

      if (isset($data)) $data->save();
    endforeach;
  }

  private function save_descriptions(Request $request, Product $product)
  {
    if (!isset($request['product_descriptions_attributes'])) return;
    foreach ($request['product_descriptions_attributes'] as $i => $row) :
      if (isset($row['id']) && $row['id'] > 0) {
        $data = InformationBlock::find($row['id']);
        if (isset($data)) {
          if (isset($row['_destroy']) && $row['_destroy'] == "true") {
            parent::delete_file($data->image);
            $data->delete();
            continue;
          } else {
            if (isset($row['_destroy_image']) && $row['_destroy_image'] == "true") {
              parent::delete_file($data->image);
              $data->image = NULL;
            }
            $data->data = $row['data'];
            $data->template = $row['template'];
          }
        }
      } else {
        $data = InformationBlock::create([
          'source' => 'products',
          'source_id' => $product->id,
          'data' => $row['data'],
          'template' => $row['template'],
        ]);
      }

      if (isset($row['image'])) {
        parent::delete_file($data->image);
        $data->image = parent::file_upload($row['image'], "product_descriptions/{$data->id}");
      }

      if (isset($data)) $data->save();
    endforeach;
  }

  private function clearResult($result)
  {
    unlink($result['original_filepath']);

    foreach ($result['dimensions'] as $value) :
      unlink($value['filepath']);
    endforeach;
  }
}
