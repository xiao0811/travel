<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        "ask",
        "options1",
        "options2",
        "options3",
        "prompt",
        "answer",
        "status",
        "type",
    ];
}
