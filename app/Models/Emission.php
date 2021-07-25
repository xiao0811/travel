<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emission extends Base
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "quantity",
        "type",
        "status",
        "remark",
    ];
}
