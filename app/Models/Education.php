<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'education';

    protected $fillable = ['university', 'logo', 'major', 'grade', 'degree', 'start_date', 'end_date', 'applicant_id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
