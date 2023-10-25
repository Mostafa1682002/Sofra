<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'discription', 'start_time', 'end_time', 'image', 'restaurant_id');



    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset("uploads/offers/$value"),
            // set: fn (string $value) => strtolower($value),
        );
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }
}
