<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $connection;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = env('DB_DATABASE_SECOND', 'u107433794_auth_eliters');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
