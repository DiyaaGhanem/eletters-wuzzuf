<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = ['status', 'notes', 'message', 'application_id'];


    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}
