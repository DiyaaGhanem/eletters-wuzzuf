<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs';

    protected $fillable = ['title', 'status', 'department', 'job_type', 'country_id', 'city_id', 'job_location', 'job_requirement', 'job_level', 'job_questions', 'min_salary', 'max_salary', 'corporate_id'];
    protected $casts = [
        'job_questions' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_jobs')
            ->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
            ->withTimestamps();
    }

    public function corporate()
    {
        return $this->belongsTo(Corporate::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
