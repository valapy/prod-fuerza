<?php
namespace App\Http\Controllers\CMS;

use App\ProductImage;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ProductImagesController extends CMSController
{
    public function show($id) {
      return ProductImage::select('id','image')->where('product_id', $id)->get();
    }

    public function destroy($id) {
      $data = ProductImage::find($id);
      if (file_exists($data->image)) unlink($data->image);
      $data->delete();
      return $data;
    }
}
