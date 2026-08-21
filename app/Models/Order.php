<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'arrangement_type',
        'client_name',
        'recipient_name',
        'company',
        'material',
        'quantity',
        'unit_price',
        'total_price',
        'status',
        'payment_proof_path',
        'product_code',
        'reference_image_path',
        'notes',
        'sender_name',
        'driver_name',
        'shipping_cost',
        'client_phone',
        'client_email',
        'dedication_message',
        'salesperson',
        'payment_method',
        'payroll_rfc',
        'payroll_area',
        'accounts_receivable_entity',
        'image_url',
        'delivery_date',
        'delivery_time',
        'delivery_address',
        'delivery_street',
        'delivery_neighborhood',
        'delivery_zip',
        'delivery_references',
        'is_in_route',
        'delivery_photo_path',
        'source',
        'nori_id',
        'extra_charge',
        'discount',
        'ticket_number',
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
