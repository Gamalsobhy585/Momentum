<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected static function booted()
{
    static::created(function ($post) {
        Cache::forget('user:info:' . $post->user_id);
    });
    
    static::updated(function ($post) {
        Cache::forget('user:info:' . $post->user_id);
    });
    
    static::deleted(function ($post) {
        Cache::forget('user:info:' . $post->user_id);
    });
    
    static::restored(function ($post) {
        Cache::forget('user:info:' . $post->user_id);
    });
}

}
