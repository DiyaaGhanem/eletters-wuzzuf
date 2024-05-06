<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interviews';

    protected $fillable = ['comments', 'status', 'date', 'interview_mail', 'location', 'review_id'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
