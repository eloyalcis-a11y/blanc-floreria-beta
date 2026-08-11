<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'client_name',
        'company',
        'material',
        'quantity',
        'unit_price',
        'total_price',
        'status',
        'payment_method',
        'image_url',
        'delivery_date',
        'is_in_route',
        'source',
        'nori_id',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'is_in_route' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
