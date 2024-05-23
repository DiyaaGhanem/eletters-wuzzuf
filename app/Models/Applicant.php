<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'applicants';

    protected $fillable = ['name', 'job_title', 'email', 'phone', 'country', 'city', 'bio', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function languages()
    {
        return $this->hasMany(ApplicantLanguage::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'applicant_skills', 'applicant_id', 'skill_id')
            ->withTimestamps();
    }
}
