<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    public function from_post()
    {
        return $this->belongsTo(Post::class);
    }

    public function get_author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}
