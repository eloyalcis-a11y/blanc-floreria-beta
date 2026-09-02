<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderArrangement extends Model
{
    protected $fillable = [
        'order_id',
        'arrangement_type',
        'product_code',
        'material',
        'quantity',
        'image_url',
        'reference_image_path',
        'notes',
        'dedication_message',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
