<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Eloquent 会自动保护插入的字段，要插入某个字段要写在 $fillable 属性中
    protected $fillable = ['content'];

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
