<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = ['name', 'description', 'data_type', 'is_unique', 'is_required'];

    public function corporateDocuments()
    {
        return $this->hasMany(CorporateDocument::class);
    }
}
