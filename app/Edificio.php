<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model{

  public $timestamps = false;

  public function habitaciones(){
    return $this->hasMany('App\Habitacion');
  }
}
