<?php

namespace App\Http\Controllers;

use App\Models\ArchiveList;
use App\Models\Comments;
use App\Models\Post;

class AdminController extends Controller
{
    public function index(){
        $archive_list_count = ArchiveList::count();
        $posts_archived_count = Post::count();
        $comments_archived_count = Comments::count();
        return view('admin.home', compact(
        'archive_list_count',
        'posts_archived_count',
            'comments_archived_count'
        ));
    }
    public function list(){
        return view('admin.list');
    }
}
