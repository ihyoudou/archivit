<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    public function getUser($username = null){
        $posts = Post::whereHas('author', function($q) use ($username) {
            $q->where('name', $username);
        })
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return view('index', compact('posts'));
    }
}
