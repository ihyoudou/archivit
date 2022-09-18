<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ArchiveList;

class Toarchivelist extends Component
{
    public $deleteId;

    protected $listeners = [
        'itemAdded' => '$refresh',
        'itemRemoved' => '$refresh',
    ];

    public function render()
    {
        $archive_list = ArchiveList::orderBy('name', 'ASC')->paginate(25);
        return view('livewire.toarchivelist', compact('archive_list'));
    }


    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $archive_item = ArchiveList::where('id', '=', $this->deleteId)->delete();
        if($archive_item){
            session()->flash('message','Item deleted successfully!');
        }

        $this->emit('itemRemoved');
    }
}
