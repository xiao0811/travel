<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

    protected $dateFormat = 'Y-m-d H:i:s';
}
