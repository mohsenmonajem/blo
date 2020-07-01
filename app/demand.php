<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class demand extends Model
{
  protected $fillable = [
      'teacheruserid ', 'studentuserid '
  ];
  public $timestamps = false;
  protected $table='studentdemand';
}
