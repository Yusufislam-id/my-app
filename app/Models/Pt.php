<?php
// app/Models/Pt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pt extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'is_active'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
