<?php

namespace App;

use App\InformationBlock;
use Illuminate\Database\Eloquent\Model;

class UsedProduct extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'model',
      'description',
      'contact',
      'financing',
      'image',
  ];

  protected $hidden = ['updated_at', 'created_at'];

  public static function models() {
    $products = UsedProduct::all();
    $data = [];

    foreach($products as $product):
      if (strlen($product->model) === 0 || !$product->model) continue;
      $data[] = $product->model;
    endforeach;

    asort($data);
    return array_unique($data);
  }
}
