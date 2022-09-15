<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'uri',
        'original_source',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
