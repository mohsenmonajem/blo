<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Student extends Model
{

    use Notifiable;
    protected $fillable = [
        'userid', 'studnetkey '
    ];

    public $timestamps = false;
    protected $table='student';
    public function gettingdata()
    {
        return 1;
    }
    public function Users()
    {
        return $this->belongsTo(User::class,'userid');
    }
    

}
