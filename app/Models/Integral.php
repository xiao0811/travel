<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integral extends Model
{
    use HasFactory;

    protected $fillable = [
        "member_id",
        "type",
        "quantity",
        "order_number",
        "interactor",
        "status"
    ];
}
