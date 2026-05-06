<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'branch_id', 'role',
        'photo', 'is_active', 'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignedShipments()
    {
        return $this->hasMany(Shipment::class, 'courier_id');
    }

    public function createdShipments()
    {
        return $this->hasMany(Shipment::class, 'created_by');
    }

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isBranchAdmin(): bool { return $this->role === 'branch_admin'; }
    public function isCourier(): bool   { return $this->role === 'courier'; }
    public function isManager(): bool   { return $this->role === 'manager'; }
}
