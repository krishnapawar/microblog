<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'name',
        'type',
        'filepath',
    ];

    public function likes()
    {
       return $this->hasMany('App\Models\Like','file_id');
    }
}
