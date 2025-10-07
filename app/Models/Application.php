<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
        protected $fillable = [
        'user_id',
        'contact_email',
        'contact_phone',
        'date_of_birth',
        'gender',
        'country',
        'comments',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
