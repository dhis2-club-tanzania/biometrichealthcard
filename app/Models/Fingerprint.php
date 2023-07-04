<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fingerprint extends Model
{
    use HasFactory;

    protected $primaryKey = 'fingerprint_no';

    protected $fillable = [
        'fingerprint_no',
        'nhif_member_id',
        'fingerprint_status',
    ];

    /**
     * Get the nhif member that owns the phone.
     */
    public function nhif_member(): BelongsTo
    {
        return $this->belongsTo(NhifMember::class);
    }

    /**
     * Return HasMany
     * Get all authentications of a fingerprint
     */
    public function authentication(): HasMany
    {
        return $this->hasMany(Authentication::class);
    }

}
