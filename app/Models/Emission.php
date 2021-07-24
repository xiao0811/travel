<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emission extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "quantity",
        "type",
        "status",
        "remark",
    ];

    protected $dateFormat = 'Y-m-d H:i:s';
}
