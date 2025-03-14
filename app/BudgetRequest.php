<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{
    static public $status = [
      0 => 'Cancelado',
      1 => 'Pendiente',
      2 => 'Revisión',
      3 => 'Archivado'
    ];

    protected $table = 'budget_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id', 'name', 'product_of_interest', 'contact_method', 'contact_value', 'message', 'status'
    ];

    public function office() {
      return $this->hasOne('App\Office', 'id', 'office_id')->first();
    }

    public function displayStatus() {
      return self::$status[$this->status];
    }

    public function displayStatusLabel() {
      $label = '';
      switch($this->status) { 
        case 0: $label = 'danger'; break; 
        case 1: $label = 'warning'; break; 
        case 2: $label = 'info'; break; 
        case 3: $label = 'success'; break; 
        default: break;
      }

      $text = $this->displayStatus();

      return "<span class='label label-$label'>$text</span>";
    }

    public function displayContactMethod() {
      switch ($this->contact_method) {
        case 'phone': return 'teléfono';
        default: return $this->contact_method;
      }
    }
}