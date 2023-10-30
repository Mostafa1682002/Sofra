<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Client  extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'regoin_id', 'image', 'remember_me', 'api_token', 'code', 'active');
    protected $hidden = array('password', 'remember_me', 'api_token', 'code');



    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset("uploads/clients/$value"),
            // set: fn (string $value) => strtolower($value),
        );
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
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function token()
    {
        return $this->morphOne('App\Models\Token', 'tokenable');
    }

    public function restaurants()
    {
        return $this->belongsToMany('App\Models\Restaurant', 'reviews')->withPivot('rate', 'comment');
    }
}