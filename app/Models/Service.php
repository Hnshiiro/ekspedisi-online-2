<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price_multiplier'];

    protected function casts(): array
    {
        return ['price_multiplier' => 'decimal:2'];
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
