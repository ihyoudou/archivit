<?php

namespace App\Http\Livewire;

use App\Models\Comments;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class ShowComments extends Component
{
    public $post_rid;

    public function mount($post_rid){
        $this->post_rid = $post_rid;
    }

    public function render()
    {

        $comments = Cache::remember('comments_'.$this->post_rid, 120, function () {
            return Comments::where('parent_id', $this->post_rid)->with('replies')->orderBy('created_at')->get();
        });

        return view('livewire.show-comments', compact('comments'));
    }
}
