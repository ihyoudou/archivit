<?php

namespace App\Http\Livewire;

use App\Models\ArchiveList;
use Livewire\Component;

class AdminAddToArchiveListForm extends Component
{
    public $item_name;
    public $item_type;

    protected $rules = [
        'item_name' => 'required',
        'item_type' => 'required',
    ];

    public function render()
    {
        return view('livewire.admin-add-to-archive-list-form');
    }

    public function submit()
    {
        $this->validate();
        // Execution doesn't reach here if validation fails.
        $check_if_doesnt_exist = ArchiveList::where('name', '=', $this->item_name)
            ->where('type', '=', $this->item_type)
            ->count();

        if($check_if_doesnt_exist == 0){
            $item = ArchiveList::create([
                'name' => $this->item_name,
                'type' => $this->item_type,
            ]);
            session()->flash('message', 'Item successfully added.');
            $this->emit('itemAdded', $item->id);
        } else {
            session()->flash('message', 'Item already exist.');
        }

    }
}
