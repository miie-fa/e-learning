<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'link',
        'title',
        'price',
        'desc',
    ];

    public function userVideo()
    {
        return $this->hasOne(UserVideo::class);
    }
}
