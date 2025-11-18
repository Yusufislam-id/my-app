<?php
// app/Models/File.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'pt_id',
        'user_id',
        'form_id',
        'name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'disk'
    ];

    public function pt()
    {
        return $this->belongsTo(Pt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
