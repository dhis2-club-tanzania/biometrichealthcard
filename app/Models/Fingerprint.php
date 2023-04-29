<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fingerprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'fingerprint_no',
        'member_id',
        'fingerprint_status',
    ];

    /**
     * Get the nhif member that owns the phone.
     */
    public function nhifmember(): BelongsTo
    {
        return $this->belongsTo(NhifMember::class);
    }
}
