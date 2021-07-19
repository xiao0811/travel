<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
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
