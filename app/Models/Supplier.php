<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function book(){
        return $this->hasMany(Book::class);
    }

    protected $guarded = [];
}
