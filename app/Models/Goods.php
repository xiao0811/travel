<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goods extends Base
{
    use HasFactory;

    protected $fillable = [
        "name",
        "number",
        "price",
        "integral",
        "quantity",
        "images",
        "details",
        "type",
        "status",
        "recommend",
        "sold",
    ];
}
