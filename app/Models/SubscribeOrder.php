<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeOrder extends Model
{
    use HasFactory;

    public function subscribe()
    {
        return $this->belongsTo('App\Models\Subscribe');
    }
}
