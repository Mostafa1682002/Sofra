<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regoin extends Model 
{

    protected $table = 'regoins';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

}