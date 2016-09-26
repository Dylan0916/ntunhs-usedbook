<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class favorites_list extends Model
{
    protected $fillable = [
      'user_id', 'book_data_id'
    ];

    public function book_data()
    {
      return $this->belongsTo('App\book_data');
    }
}
