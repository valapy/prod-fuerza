<?php

namespace App\Http\Controllers\CMS;

use App\UsedProduct;
use Illuminate\Http\Request;

use Imageupload;

class UsedProductsController extends CMSController
{
  public function index() {
    return view('cms.used_products.index', ['data' => UsedProduct::orderBy('model')->get()]);
  }

  public function create() {
    $data = NULL;
    return view('cms.used_products.form', compact('data'));
  }

  public function store(Request $request) {
    $data = UsedProduct::create($this->getParams($request));
    $this->upload($request, $data);

    return redirect('cms/used_products')->with('success', "El producto fué agregado correctamente.");
  }

  public function edit($id) {
    $data = UsedProduct::find($id);

    if ($data == NULL) return redirect('cms/used_products')->with('error', "El producto no existe.");
    return view('cms.used_products.form', compact('data'));
  }

  public function update(Request $request, $id) {
    $data = UsedProduct::find($id);

    $data->update($this->getParams($request));

    foreach (['image'] as $key):
      if ($request->get("_destroy_$key") == "true" && $data->$key != NULL && file_exists($data->$key)) {
        parent::delete_file($data->$key);
        $data->$key = NULL;
      }
    endforeach;

    $this->upload($request, $data);

    return redirect('cms/used_products')->with('success', "El producto fue actualizado correctamente.");
  }

  public function destroy($id) {
    $data = UsedProduct::find($id);

    parent::delete_file($data->image);

    $data->delete();

    return redirect('cms/used_products')->with('success', "El producto fue eliminado correctamente.");
  }

  private function getParams(Request $request) {
    $permit = [
      'model',
      'description',
      'contact',
      'financing',
      'image',
    ];

    foreach ($permit as $field):
      if ($request->get($field) == NULL) continue;
      $result[$field] = $request->get($field);
    endforeach;

    return $result;
  }

  private function upload(Request $request, UsedProduct $data) {
    if ($request->hasFile('image')) {
      parent::delete_file($data->image);
      $data->image = parent::file_upload($request->image, "used_products/{$data->id}");
    }

    $data->save();
  }
}
