<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message_board extends Model
{
    protected $fillable = [
      'book_data_id', 'user_id', 'area', 'content'
    ];

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
