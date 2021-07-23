<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
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

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getType()
    {
        return [
            1 => "国内资讯",
            2 => "安徽资讯",
            3 => "合肥资讯",
        ];
    }
}
