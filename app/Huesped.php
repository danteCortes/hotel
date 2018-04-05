<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Huesped extends Model{

  protected $table = 'huespedes';

  public $timestamps = false;

  public function persona(){
    return $this->belongsTo('\App\Persona', 'persona_dni', 'dni');
  }

  public function habitacion(){
    return $this->belongsTo('App\Habitacion');
  }

  public function pagos(){
    return $this->hasMany('App\Pago');
  }
}
