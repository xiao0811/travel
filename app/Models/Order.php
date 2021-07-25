<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Base
{
    use HasFactory;

    protected $fillable = [
        "address",
        "name",
        "phone",
        "remark",
        "express",
        "express_number"
    ];
}
