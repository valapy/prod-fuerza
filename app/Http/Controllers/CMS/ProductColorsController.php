<?php
namespace App\Http\Controllers\CMS;

use App\ProductImage;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ProductColorsController extends CMSController
{
    public function show($id) {
      return ProductColor::select('id', 'color','image')->where('product_id', $id)->get();
    }

    public function destroy($id) {
      $data = ProductColor::find($id);
      if (file_exists($data->image)) unlink($data->image);
      $data->delete();
      return $data;
    }
}
