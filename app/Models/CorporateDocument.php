<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateDocument extends Model
{
    use HasFactory;

    protected $table = 'corporate_documents';
    protected $fillable = ['corporate_id', 'document_id', 'value', 'status'];


    public function corporate()
    {
        return $this->belongsTo(Corporate::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
