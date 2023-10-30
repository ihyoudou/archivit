<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'reddit_post_id',
        'uri',
        'original_source',
        'hash',
    ];

    public function from_post()
    {
        return $this->belongsTo(Post::class);
    }
}
