<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limpieza extends Model{

  public $timestamps = false;

  public function habitacion(){
    return $this->belongsTo('App\Habitacion');
  }
    //
}
