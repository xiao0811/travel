<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Base extends Model
{
    /**
     * 为数组/ JSON序列化准备一个日期。
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::instance($date)->toDateTimeString(); //这里使用toDateTimeString，不受Carbon中时区的影响
    }
}
