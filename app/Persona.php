<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model{

  public $primaryKey = 'dni';

  public $incrementing = false;

  protected $keyType = 'string';

  public $timestamps = false;
}
