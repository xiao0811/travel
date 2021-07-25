<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Base
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
