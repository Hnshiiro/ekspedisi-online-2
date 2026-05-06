<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingRoute extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'origin_city', 'destination_city', 'price_per_kg', 'estimated_days',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg'   => 'decimal:2',
            'estimated_days' => 'integer',
        ];
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'route_id');
    }
}
