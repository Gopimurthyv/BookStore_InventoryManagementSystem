<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDetails extends Model
{
    public function book(){
        return $this->belongsTo(Book::class);
    }

    protected $guarded = [];
}
