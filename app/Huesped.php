<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Huesped extends Model{

  protected $table = 'huespedes';

  public $timestamps = false;

  public function persona(){
    return $this->belongsTo('\App\Persona');
  }
}
