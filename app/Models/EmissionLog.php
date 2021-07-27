<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantity",
        "status",
        "type",
        "correspond",
        "remark",
    ];
}
