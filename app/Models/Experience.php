<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'experiences';
    protected $fillable = ['company', 'logo', 'job_title', 'description', 'job_type', 'job_location', 'start_date', 'end_date', 'applicant_id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

}
