<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'price_offer', 'processing_time', 'image', 'restaurant_id');

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset("uploads/products/$value"),
            // set: fn (string $value) => strtolower($value),
        );
    }





    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('price', 'quantity', 'notes');
    }
}
