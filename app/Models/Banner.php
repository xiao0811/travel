<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        "url",
        "type",
        "sort",
        "status",
        "remark",
    ];

    public function setUrlAttribute($url)
    {
        if (is_array($url)) {
            $this->attributes['url'] = json_encode($url);
        }
    }

    public function getUrlAttribute($url)
    {
        return json_decode($url, true);
    }
}
