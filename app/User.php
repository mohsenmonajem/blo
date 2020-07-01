<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','remmeber_token','family','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

    /**
     * The attributes that should be cast to native types.
     *
     *     protected $table='teacher';
     * @var array
     */
    protected $table='users';
    public $timestamps = false;

    public function Teachers()
    {
              return $this->hasOne(Teacher::class,'userid');

    }
    public function Students()
    {
        return $this->hasOne(Student::class,'userid');
        
    }
}
