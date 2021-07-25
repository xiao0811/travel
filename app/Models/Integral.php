<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Integral extends Base
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
