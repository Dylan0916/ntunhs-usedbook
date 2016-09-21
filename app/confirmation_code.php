<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class confirmation_code extends Model
{
    protected $fillable = [
      'email', 'code',
    ];
}
