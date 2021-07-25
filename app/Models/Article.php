<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Base
{
    use HasFactory;

    protected $fillable = [
        "title",
        "subtitle",
        "content",
        "author",
        "status",
        "type",
        "sort",
        "thumbnail",
    ];

    public function getType()
    {
        return [
            1 => "国内资讯",
            2 => "安徽资讯",
            3 => "合肥资讯",
        ];
    }
}
