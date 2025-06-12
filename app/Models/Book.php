<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function authors(){
        return $this->hasMany(BookAuthors::class);
    }

    public function stocks(){
        return $this->hasMany(StockDetails::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    protected $casts = [
        'categories' => 'array',
    ];

    protected $guarded = [];

}
