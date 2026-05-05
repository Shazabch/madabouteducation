<?php

namespace App\Http\Livewire\Parent;

use App\Models\Children;
use App\Models\Country;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ChildrenComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Children $children;
    public $editableMode = false;
    public $guardians = [];
    public $countries = [];

    protected $rules = [
        'children.name' => 'required',
        'children.age' => 'required|numeric|max:25',
        'children.passport_no' => 'nullable|max:255',
        'children.date_of_birth' => 'nullable',
        'children.gender' => 'required',
        'children.nationality' => 'required',
        'children.guardian_id' => 'required',
        'children.guardian_id_2' => 'nullable',
        'children.name_of_school_attending' => 'nullable',
        'children.current_grade_in_school' => 'nullable',
    ];

    public function mount()
    {
        $this->children = new Children();
        $this->countries = Country::all();
        $this->getGuardians();
    }


    public function updatedChildrenDateOfBirth($value)
    {
        if ($value) {
            $this->children['age'] = Carbon::parse($value)->age;
        } else {
            $this->children['age'] = null;
        }
    }

    protected function getListeners()
    {
        return ['refreshChildren' => 'getGuardians'];
    }

    public function getGuardians()
    {
        $this->guardians = auth()->user()->guardians;
    }

    public function createOrEdit($id = null)
    {
        if ($id) {
            $this->children = Children::find($id);
        } else {
            $this->children = new Children();
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->validate();
        isset($this->children->id) ? '' : $this->children->user_id = auth()->id();
        $this->children->save();
        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Children saved successfully.']);
    }

    public function delete($id)
    {
        Children::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Children deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.parent.children-component', ['childrens' => Children::where('user_id', auth()->id())->latest()->paginate(10)]);
    }
}
