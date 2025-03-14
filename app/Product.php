<?php

namespace App;

use App\InformationBlock;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
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
      'spot_price',
      'specs',
  ];

  protected $casts = [
    'active' => 'boolean',
  ];

  protected $hidden = ['updated_at', 'created_at'];

  public function descriptions() {
    return InformationBlock::for_source('products', $this->id);
  }

  public function colors() {
    return $this->hasMany('App\ProductColor');
  }

  public function images() {
    return $this->hasMany('App\ProductImage');
  }

  public function toArray() {
    // get the original array to be displayed
    $data = parent::toArray();

    $data['images'] = $this->images()->get()->toArray();
    $data['colors'] = $this->colors()->get()->toArray();

    return $data;
  }

  public static function categories() {
    $products = Product::where('active', true)->get();
    $data = [];

    foreach($products as $product):
      if (strlen($product->category) === 0 || !$product->category) continue;
      $data[] = $product->category;
    endforeach;

    asort($data);
    return array_unique($data);
  }

  public static function brakes() {
    $products = Product::where('active', true)->get();
    $data = [];

    foreach($products as $product):
      $specs = json_decode($product->specs, true);
      if ($specs === false || !is_object($specs)) continue;
      foreach ($specs['Frenos'] as $value):
        if (strlen($value) === 0 || !$value) continue;
        $product_brakes[] = $value;
      endforeach;
    endforeach;

    asort($data);
    return array_unique($data);
  }

  public static function engines() {
    $products = Product::where('active', true)->get();
    $data = [];

    foreach($products as $product):
      $specs = json_decode($product->specs, true);
      if ($specs === false || !is_object($specs)) continue;
      foreach ($specs as $row):
        foreach($row as $key=>$value):
          if (strlen($value) === 0 || !$value) continue;
          if (stripos($key, 'Cilindrada') !== false) $data[] = $value;
        endforeach;
      endforeach;
    endforeach;

    asort($data);
    return array_unique($data);
  }

  public static function tires() {
    $products = Product::all();
    $data = [];

    foreach($products as $product):
      $specs = json_decode($product->specs, true);
      if ($specs === false || !is_object($specs)) continue;
      foreach ($specs['Ruedas'] as $key=>$value):
        if (strlen($value) === 0 || !$value) continue;
        if (stripos($key, 'delantera') !== false || stripos($key, 'trasera') !== false) {
          $product_tires[] = $value;
        }
      endforeach;
    endforeach;

    asort($data);
    return array_unique($data);
  }
}
