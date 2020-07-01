<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Teacher_dars extends Model
{
    public $timestamps = false;
    protected $table='dars_teacher';
    protected $fillable = [
        'dars_id', 'teacher_id'
    ];
}
