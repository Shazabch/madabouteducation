<?php

namespace App\Http\Livewire\Admin;

use App\Models\Program;
use App\Models\TimeTable;
use Livewire\Component;
use Livewire\WithPagination;

class TimeTableComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public TimeTable $timeTable;
    public $program;
    public $programId;
    public $editableMode=false;
    public $activities = [];


    protected $rules=[
        'timeTable.title'=>'required',
        'activities.*.hour'=>'required',
        'activities.*.activity'=>'required',
        ];

    public function mount()
    {
        $this->timeTable=new TimeTable();
        $this->getProgram();
    }

    public function addActivity()
    {
        $this->activities[] = [
            'hour' => '',
            'activity' => ''
        ];
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function getProgram(){
        $this->program=Program::find($this->programId);
    }

    public function createOrEdit($id=null)
    {
        $this->activities=[];
        if($id)
        {
            $this->timeTable=TimeTable::find($id);
            $this->activities=$this->timeTable->activities();
        }
        else{
            $this->timeTable=new TimeTable();
        }
        $this->editableMode=true;
    }

    public function cancelEdit()
    {
        $this->editableMode=false;
    }

    public function save()
    {
        $this->validate();
        $this->timeTable->activities=json_encode($this->activities);
        $this->timeTable->program_id=$this->programId;
        $this->timeTable->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'TimeTable saved successfully.']);
    }

    public function delete($id)
    {
        TimeTable::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'TimeTable deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.time-table-component',['timeTables'=>TimeTable::latest()->paginate(10)]);
    }
}
