<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Restaurant   extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'regoin_id', 'minimum_order', 'delivary_cost', 'whatsapp', 'image', 'status', 'remember_me', 'api_token', 'code', 'active');
    protected $hidden = array('password', 'remember_me', 'api_token', 'code');

    // use Illuminate\Database\Eloquent\Casts\Attribute;
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset("uploads/restaurants/$value"),
            // set: fn (string $value) => strtolower($value),
        );
    }






    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function regoin()
    {
        return $this->belongsTo('App\Models\Regoin');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Offer', 'notificationable');
    }

    public function token()
    {
        return $this->morphOne('App\Models\Token', 'tokenable');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'reviews')->withPivot('rate', 'comment');
    }
}
