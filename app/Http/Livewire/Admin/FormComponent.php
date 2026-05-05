<?php

namespace App\Http\Livewire\Admin;

use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class FormComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Form $form;
    public $editableMode=false;
    public $questions = []; 
    public $types = ['text','date_picker','options_single','options_multiple']; 

    protected $rules=[
        'form.title'=>'required',
        'form.questions'=>'nullable',
        ];

    public function mount()
    {
        $this->form=new Form();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'title' => '',
            'description' => '',
            'required' => false,
            'is_heading' => false,
            'answer_type' => '',
            'options'=>''
        ];
    }

    public function addHeading()
    {
        $this->questions[] = [
            'title' => '',
            'description' => '',
            'required' => false,
            'is_heading' => true,
            'answer_type' => '',
            'options'=>''
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function createOrEdit($id=null)
    {
        $this->questions=[];
        $this->resetErrorBag();
        $this->editableMode=true;
        if($id)
        {
            $this->form=Form::find($id);
            $this->questions=$this->form->getQuestions();
        }
        else{
            $this->form=new Form();
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
        foreach($this->questions as $index=>$q){
            if(!in_array($q['answer_type'],['options_single','options_multiple'])){
                $this->questions[$index]['options']='';
            }
        }
        $this->form->questions=json_encode($this->questions);
        $this->form->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Form saved successfully.']);
    }

    public function delete($id)
    {
        Form::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Form deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.form-component',['forms'=>Form::latest()->paginate(10)]);
    }
}
