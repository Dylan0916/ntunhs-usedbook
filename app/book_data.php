<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class book_data extends Model
{
    protected $fillable = [
      'book_ISBN', 'department_id', 'book_name', 'book_author',
      'book_publish', 'book_price', 'book_price2', 'book_status',
      'book_img', 'book_other', 'user_id',
    ];

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function favorites_list()
    {
      return $this->hasMany('App\favorites_list');
    }
}
