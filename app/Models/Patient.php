<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fingerprint_no',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return $value ? 'true' : 'false';
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value === 'true' || $value === true;
    }
}
