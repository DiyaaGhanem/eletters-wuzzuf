<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interview_statuses';

    protected $fillable = ['comments', 'status', 'interview_mail', 'application_id'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
