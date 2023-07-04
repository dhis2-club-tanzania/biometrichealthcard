<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\NhifMember as Authenticatable;

class NhifMember extends Model
{
    use HasFactory, HasApiTokens;


    protected $primaryKey = 'id';

    protected $fillable = [
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
        'card_status',
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
     * Get the fingerprint associated with the member.
     */
    public function fingerprint(): HasOne
    {
        return $this->hasOne(Fingerprint::class);
    }
}
