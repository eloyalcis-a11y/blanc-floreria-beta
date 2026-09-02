<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'client_name',
        'recipient_name',
        'company',
        'unit_price',
        'total_price',
        'status',
        'payment_proof_path',
        'sender_name',
        'driver_name',
        'shipping_cost',
        'client_phone',
        'client_email',
        'salesperson',
        'payment_method',
        'payroll_rfc',
        'payroll_area',
        'accounts_receivable_entity',
        'delivery_date',
        'delivery_time',
        'delivery_address',
        'delivery_street',
        'delivery_neighborhood',
        'delivery_zip',
        'delivery_references',
        'delivery_reference_image_path',
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

    public function arrangements()
    {
        return $this->hasMany(OrderArrangement::class);
    }

    public function getMaterialAttribute()
    {
        return $this->arrangements->pluck('material')->filter()->join(' + ');
    }

    public function getQuantityAttribute()
    {
        return $this->arrangements->sum('quantity');
    }

    public function getProductCodeAttribute()
    {
        return $this->arrangements->pluck('product_code')->filter()->join(', ');
    }

    public function getNotesAttribute()
    {
        return $this->arrangements->pluck('notes')->filter()->join(' | ');
    }

    public function getDedicationMessageAttribute()
    {
        return $this->arrangements->pluck('dedication_message')->filter()->join(' | ');
    }

    public function getArrangementTypeAttribute()
    {
        return $this->arrangements->pluck('arrangement_type')->filter()->unique()->join(', ');
    }
}
