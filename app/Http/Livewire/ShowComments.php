<?php

namespace App\Http\Livewire;

use App\Models\Comments;
use Livewire\Component;

class ShowComments extends Component
{
    public $post_rid;

    public function mount($post_rid){
        $this->post_rid = $post_rid;
    }

    public function render()
    {
        $comments = Comments::where('parent_id', $this->post_rid)->with('replies')->get();
        return view('livewire.show-comments', compact('comments'));
    }
}
