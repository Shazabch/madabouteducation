<?php

namespace App\Http\Livewire;

use App\Models\Program;
use Livewire\Component;

class SearchProgramsComponent extends Component
{

    public $search;
    public $totalPrograms = [];

    public function mount()
    {
        $this->totalPrograms = [];
    }

    public function updatedSearch()
    {
        if(!empty($this->search))
        {
        $this->totalPrograms = Program::where('title', 'LIKE', '%' . $this->search . '%')->get();
        }
        else{
            $this->totalPrograms = [];
        }

        $this->dispatchBrowserEvent('openModalSearch');
    }
    
    public function render()
    {
        return view('livewire.search-programs-component');
    }
}
