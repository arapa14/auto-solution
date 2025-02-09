<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Service extends Model
{
    use HasFactory;

    protected $table = 'order_services';

    protected $fillable = [
        'order_id',
        'service_id',
        'duration',
        'price_unit',
        'total_price',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
