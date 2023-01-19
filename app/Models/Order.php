<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total_price' , 'created_by' , 'updated_by' , 'status'];

    public function payment():hasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function orderItems():HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
