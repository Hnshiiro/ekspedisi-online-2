<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id', 'item_name', 'description', 'quantity', 'weight', 'photo',
    ];

    protected function casts(): array
    {
        return ['weight' => 'decimal:2'];
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
