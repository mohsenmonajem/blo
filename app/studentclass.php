<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class studentclass extends Model {
    protected $fillable = [
        'studentkey', 'code_class '
    ];

    public $timestamps = false;
    protected $table = 'studentclass';

}
