<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['total_price' , 'created_at' , 'updated_at' , 'order_id' , 'product_id' , 'quantity','unit_price'];

    public function order():HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function product():HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
