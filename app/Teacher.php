<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    public $timestamps = false;
    protected $table='teacher';
    protected $fillable = [
      'userid', 'teacherkey'
  ];
    public function Teacher_dars()
    {
      return  $this->belongsToMany(Teacher_dars::class,'teacher_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class,'userid');
    }
    public function TeacherRequest()
    {
      return  $this->belongsToMany(TeacherRequest::class,'teacher_id');
    }
    
}
