<?php

namespace App\Http\Livewire\Parent;

use App\Models\Children;
use App\Models\Country;
use App\Models\Guardian;
use Livewire\Component;
use Livewire\WithPagination;

class GuardianComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Guardian $guardian;
    public $editableMode=false;
    public $countries=[];

    protected $rules=[
        'guardian.name'=>'required',
        'guardian.relationship'=>'required',
        'guardian.email'=>'required',
        'guardian.contact_no'=>'required',
        'guardian.residential_address'=>'required',
        'guardian.nationality'=>'required',
        ];

    public function mount()
    {
        $this->guardian=new Guardian();
        $this->countries=Country::all();
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->guardian=Guardian::find($id);
        }
        else{
            $this->guardian=new Guardian();
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
        isset($this->guardian->id) ? '':$this->guardian->user_id=auth()->id();
        $this->guardian->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Guardian saved successfully.']);
        $this->emitTo('parent.children-component', 'refreshChildren');
    }

    public function delete($id)
    {
        Guardian::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Guardian deleted successfully.']);
        $this->emitTo('parent.children-component', 'refreshChildren');
    }

    public function render()
    {
        return view('livewire.parent.guardian-component',['guardians'=>Guardian::where('user_id',auth()->id())->latest()->paginate(10)]);
    }
}
