<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobileno',
        'is_otp_verified',
        'role',
        
    ];
    public function hasRole(string $role): bool
    {
        return $this->role === $role; // Assuming you have a `role` column in your `users` table
    }

    /**
     * Define a relationship to the CompanyDetail model.
     */
    public function companyDetails()
    {
        return $this->hasOne(CompanyDetail::class, 'business_id');
    }

    

}
