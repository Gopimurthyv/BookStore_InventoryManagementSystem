<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    public function authors(){
        return $this->hasMany(BookAuthors::class);
    }

    public function stocks(){
        return $this->hasMany(StockDetails::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    protected $casts = [
        'categories' => 'array',
    ];

    protected $dates = ['deleted_at'];

    protected $guarded = [];

}
