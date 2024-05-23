<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'applications';

    protected $fillable = ['cover_letters', 'notice_period', 'application_date', 'expected_salary', 'answers', 'cv', 'candidate_profile_link', 'job_id', 'user_id'];

    protected $casts = [
        'answers' => 'json'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function interviewStatuses()
    {
        return $this->hasMany(interviewStatus::class);
    }
}
