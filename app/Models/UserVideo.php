<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVideo extends Model
{
    use HasFactory;

    protected $table = 'user_videos';

    protected $fillable = [
        'user_id',
        'video_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function videos()
    {
        return $this->belongsTo(Video::class,'video_id','id');
    }
}
