<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id' , 'type' , 'amount','session_id', 'created_by' , 'updated_by' , 'status'];

    public function order():hasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
    }
}
