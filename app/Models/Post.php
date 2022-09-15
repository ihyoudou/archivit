<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'reddit_id',
        'title',
        'selftext',
        'author_id',
        'source_id',
        'permalink',
        'upvotes',
        'downvotes',
        'locked'
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function source(){
        return $this->belongsTo(ArchiveList::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
