<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicantSkill extends Pivot
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'applicant_skills';
    protected $fillable = ['applicant_id', 'skill_id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}