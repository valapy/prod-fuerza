<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'title', 'content', 'date', 'image'
  ];

  protected $visible = [
    'id', 'title', 'content', 'date', 'image', 'formattedDate'
  ];

  function formattedDate() {
    return strtr(date('j \d\e M \d\e Y', strtotime($this->date)), [
      'Jan' => 'Enero',
      'Feb' => 'Febrero',
      'Mar' => 'Marzo',
      'Apr' => 'Abril',
      'May' => 'Mayo',
      'Jun' => 'Junio',
      'Jul' => 'Julio',
      'Aug' => 'Agosto',
      'Sep' => 'Septiembre',
      'Oct' => 'Octubre',
      'Nov' => 'Noviembre',
      'Dec' => 'Diciembre'
    ]);
  }

  // public function images() {
  //   return $this->hasMany('App\NewsImage');
  // }

  public function toArray() {
    // get the original array to be displayed
    $data = parent::toArray();
    $data['date'] = $this->formattedDate();

    return $data;
  }
}
