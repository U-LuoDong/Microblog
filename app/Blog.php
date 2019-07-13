<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['content'];//设置一个允许填充的字段
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
