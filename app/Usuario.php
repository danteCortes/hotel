<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable{

  use Notifiable;

  public $timestamps = false;

  protected $fillable = ['persona_dni', 'password', 'tipo'];

  public function persona(){
    return $this->belongsTo('\App\Persona', 'persona_dni', 'dni');
  }

  public function tienda(){
    return $this->belongsTo('\App\Tienda');
  }

}
