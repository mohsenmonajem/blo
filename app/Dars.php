<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Dars extends Model
{
  protected $fillable = [
      'id ', 'namelesson','payenumber'
  ];
    public $timestamps = false;
    protected $table='dars';
    public function get()
    {
       $dars=new Dars;
       $dars->namelesson='arabi';
       return $dars->namelesson;
    }
    public function Teacher_dars()
    {
      return  $this->belongsToMany(Teacher_dars::class,'dars_id');
    }
    public function teacher()
    {
      return  $this->belongsToMany('teacher');
    }
}
