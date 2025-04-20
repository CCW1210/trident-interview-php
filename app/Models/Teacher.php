<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // 允许批量写入的字段
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    // … 其他已写代码 …
}
