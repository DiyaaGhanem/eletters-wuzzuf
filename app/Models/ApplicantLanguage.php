<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicantLanguage extends Pivot
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'applicant_languages';

    protected $fillable = ['level', 'rating', 'applicant_id', 'language_id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
