<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProgramGroup;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProgramGroupComponent extends Component
{
    public $program;
    public $groups=[];
    public ProgramGroup $group;
    public $editableMode = false;
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->getGroups();
        $this->group=new ProgramGroup();
    }

    public function rules(){
        return [
            'group.title' => 'required',
            'group.start_date' => 'required',
            'group.end_date' => Rule::requiredIf(!$this->group->is_reoccuring),
            'group.age_group' => 'required',
            'group.age_group_extra_info' => 'nullable',
            'group.price' => 'required|numeric',
            'group.total_slots' => 'required|numeric|min:1',
            'group.booked_slots' => 'required|numeric',
            'group.is_reoccuring' => 'nullable',
            'group.time' => 'nullable',
        ];
    }

    public function getGroups(){
        $this->program->load('groups');
        $this->groups=$this->program->groups;
    }

    public function updatingGroupIsReoccuring($is_reoccuring)
    {
        if ($is_reoccuring) {
            $this->group->end_date = null;
        }
    }



    public function createOrEdit($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $this->group = ProgramGroup::find($id);
        } else {
            $this->group = new ProgramGroup(['price' => 0, 'booked_slots' => 0, 'total_slots' => 0, 'is_reoccuring' => false]);
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->group->is_reoccuring = $this->group->is_reoccuring ? true : false;
        $this->validate();
        $this->group->program_id=$this->program->id;
        $this->group->save();
        $this->editableMode = false;
        $this->getGroups();
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Group saved successfully.']);
    }

    public function delete($id)
    {
        ProgramGroup::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Group deleted successfully.']);
        $this->getGroups();
    }

    public function render()
    {
        return view('livewire.admin.program-group-component');
    }
}
