<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corporate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corporates';

    protected $fillable = ['name', 'tax_register', 'commercial_record', 'country', 'city', 'address', 'logo', 'phone', 'email', 'status', 'tax_register_document', 'commercial_record_document', 'id_face', 'id_back', 'owner_title', 'user_id'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
