<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Authentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'authentication_fingerprint_user',
        'authentication_status',
        'fingerprint_id',
    ];

    public function getAuthenticationStatusAttribute($value)
    {
        return $value ? 'TRUE' : 'FALSE';
    }

    public function setAuthenticationStatusAttribute($value)
    {
        $this->attributes['authentication_status'] = $value === 'true' || $value === true;
    }

    /**
     * Get the nhif member that owns the authentication.
     */
    public function fingerprint(): BelongsTo
    {
        return $this->belongsTo(Fingerprint::class, 'fingerprint_id');
    }
}
