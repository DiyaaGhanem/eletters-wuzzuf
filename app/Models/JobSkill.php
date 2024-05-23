<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobSkill extends Pivot
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'job_skills';
    
}
