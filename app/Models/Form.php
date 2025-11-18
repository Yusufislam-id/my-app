<?php
// app/Models/Form.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'pt_id',
        'user_id',
        'type',
        'title',
        'data',
        'status'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function pt()
    {
        return $this->belongsTo(Pt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
