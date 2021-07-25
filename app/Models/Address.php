<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Base
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "name",
        "phone",
        "address",
        "default",
        "status",
    ];
}
