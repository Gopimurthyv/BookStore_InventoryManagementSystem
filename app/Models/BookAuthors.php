<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAuthors extends Model
{
    public function book(){
        return $this->belongsTo(Book::class);
    }

    protected $guarded = [];
}
