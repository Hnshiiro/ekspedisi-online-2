<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number', 'sender_id', 'receiver_id',
        'origin_branch_id', 'destination_branch_id',
        'vehicle_id', 'courier_id', 'service_id', 'created_by', 'route_id',
        'origin_city', 'destination_city',
        'sender_address', 'receiver_address',
        'description', 'total_weight', 'total_price',
        'status', 'payment_status', 'receiver_name', 'receiver_phone', 'sender_name', 'sender_phone',
        'shipment_date', 'estimated_delivery_date', 'delivered_at',
        'photo', 'notes', 'snap_token', 'payment_url',
    ];

    protected function casts(): array
    {
        return [
            'shipment_date'           => 'date',
            'estimated_delivery_date' => 'date',
            'delivered_at'            => 'datetime',
            'total_weight'            => 'decimal:2',
            'total_price'             => 'decimal:2',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'pending'            => 'Menunggu Pickup',
            'picked_up'          => 'Sudah Diambil',
            'in_transit'         => 'Dalam Perjalanan',
            'arrived_at_branch'  => 'Tiba di Cabang',
            'out_for_delivery'   => 'Dalam Pengantaran',
            'delivered'          => 'Terkirim',
            'cancelled'          => 'Dibatalkan',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function sender()       { return $this->belongsTo(Customer::class, 'sender_id'); }
    public function receiver()     { return $this->belongsTo(Customer::class, 'receiver_id'); }
    public function originBranch() { return $this->belongsTo(Branch::class, 'origin_branch_id'); }
    public function destinationBranch() { return $this->belongsTo(Branch::class, 'destination_branch_id'); }
    public function vehicle()      { return $this->belongsTo(Vehicle::class); }
    public function courier()      { return $this->belongsTo(User::class, 'courier_id'); }
    public function service()      { return $this->belongsTo(Service::class); }
    public function creator()      { return $this->belongsTo(User::class, 'created_by'); }
    public function route()        { return $this->belongsTo(ShippingRoute::class, 'route_id'); }
    public function items()        { return $this->hasMany(ShipmentItem::class); }
    public function trackings()    { return $this->hasMany(ShipmentTracking::class)->orderByDesc('checked_at'); }
    public function payments()     { return $this->hasMany(Payment::class); }
}
