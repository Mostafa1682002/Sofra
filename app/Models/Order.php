<?php

namespace App\Models;

use App\Mostafa\Status;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'notes', 'cost', 'delivary_cost', 'total_cost', 'payment_type_id', 'status', 'address', 'restaurant_id', 'commission', 'confirmed_by_client');



    protected $casts = [
        'status' => Status::class
    ];


    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function paymentType()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price', 'quantity', 'notes');
    }
}
