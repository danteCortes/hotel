<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model{

  protected $table = 'habitaciones';

  public $timestamps = false;

  public function edificio(){
    return $this->belongsTo('\App\Edificio');
  }

  public function huespedes(){
    return $this->hasMany('\App\Huesped', 'habitacion_id');
  }

  public function getPrecioAttribute($precio){
    return number_format($precio, 2, '.', '');
  }

}
