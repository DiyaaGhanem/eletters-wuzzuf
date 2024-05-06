<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs';

    protected $fillable = ['title', 'department', 'job_type', 'country', 'job_location', 'job_requirement', 'job_level', 'skills_keys', 'job_questions', 'min_salary', 'max_salary', 'category_id', 'corporate_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function corporate()
    {
        return $this->belongsTo(Corporate::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
