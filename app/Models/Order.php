<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory,Notifiable;

    protected $guarded=[];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'GustCustomer'
        ]);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name','price','quantity','options',
            ]);
    }

    public function items() {
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function addresses(){
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
            ->where('type','=','billing');
    }

    public function shippingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
            ->where('type','=','shipping');
    }

    protected static function booted()
    {
        static::creating(function(Order $order){
            $order->number=Order::getNextNumber();
        });
    }

    public static function getNextNumber(){
        $year=Carbon::now()->year;
        $number= Order::whereYear('created_at',$year)->max('number');
        if($number){
            return $number + 2127;
        }
        return $number . '0001';
    }
}
