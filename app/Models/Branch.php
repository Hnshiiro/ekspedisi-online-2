<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'city', 'address', 'phone', 'email', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'origin_branch_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
