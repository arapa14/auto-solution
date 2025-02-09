<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'total_price',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order_products() {
        return $this->hasMany(Order_Product::class);
    }
    public function order_services() {
        return $this->hasMany(Order_service::class);
    }
}
