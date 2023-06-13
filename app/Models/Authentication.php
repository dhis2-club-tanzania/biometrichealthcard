<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'authentication_fingerprint_user',
        'authentication_status',
    ];

    public function getAuthenticationStatusAttribute($value)
    {
        return $value ? 'TRUE' : 'FALSE';
    }

    public function setAuthenticationStatusAttribute($value)
    {
        $this->attributes['authentication_status'] = $value === 'true' || $value === true;
    }
}
