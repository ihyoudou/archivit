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
        'author',
        'permalink',
        'media',
        'upvotes',
        'downvotes',
        'locked'
    ];

    public function author(){
        return $this->belongsTo('App\Author');
    }
}
