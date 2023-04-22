<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NhifMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        // 'FormFourIndexNo',
        'FirstName',
        // 'MiddleName',
        'Surname',
        // 'AdmissionNo',
        // 'CollageFaculty',
        'MobileNo',
        // 'ProgrammeOfStudy',
        // 'CourseDuration',
        // 'MaritalStatus',
        // 'DateJoiningEmployer',
        // 'DateOfBirth',
        // 'NationalID',
        'Gender',
        'CardNo',
        'FingerprintStatus',
        'image',
    ];

    public function getFingerprintStatusAttribute($value)
    {
        return $value ? 'TRUE' : 'FALSE';
    }

    public function setFingerprintStatusAttribute($value)
    {
        $this->attributes['FingerprintStatus'] = $value === 'true' || $value === true;
    }

    /**
     * Get the fingerprint associated with the user.
     */
    public function fingerprint(): HasOne
    {
        return $this->hasOne(Fingerprint::class);
    }
}
