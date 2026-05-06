<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'plate_number', 'brand', 'type',
        'capacity_kg', 'driver_name', 'status',
    ];

    protected function casts(): array
    {
        return ['capacity_kg' => 'decimal:2'];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
