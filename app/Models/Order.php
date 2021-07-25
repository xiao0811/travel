<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Base
{
    use HasFactory;

    protected $fillable = [
        "member_id",
        "goods_id",
        "address",
        "name",
        "phone",
        "status",
        "remark",
        "express",
        "express_number"
    ];
}
