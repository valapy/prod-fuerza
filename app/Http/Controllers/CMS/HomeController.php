<?php

namespace App\Http\Controllers\CMS;

use App\InformationBlock;
use Illuminate\Http\Request;

class HomeController extends CMSController
{
  // Home content
  public function index(Request $request) {
    $this->save_descriptions($request);
    return view('cms.home.index', ['data' => InformationBlock::where('source', 'home')->orderBy('id')->get()]);
  }

  private function save_descriptions(Request $request) {
    if (!isset($request['product_descriptions_attributes'])) return;
    foreach ($request['product_descriptions_attributes'] as $i=>$row):
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
}