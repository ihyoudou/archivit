<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function getData(){
        $posts = Post::orderBy('id', 'DESC')->paginate(15);

        return view('index', compact('posts'));
    }

    public function getSubreddit($subreddit = null){
        $posts = Post::whereHas('source', function($q) use ($subreddit) {
            $q->where('name', $subreddit);
        })
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('index', compact('posts'));
    }

    public function getPost($subreddit = null, $rid = null){
        $posts = Post::whereHas('source', function($q) use ($subreddit) {
            $q->where('name', $subreddit);
        })
            ->where('reddit_id', $rid)
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('index', compact('posts'));
    }
}
