<?php

namespace App\Http\Livewire\Admin;

use App\Models\NewsletterSubcription;
use Livewire\Component;
use Livewire\WithPagination;

class NewsletterSubcriptionComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public NewsletterSubcription $newsletterSubcription;
    public $editableMode=false;

    protected $rules=[
        'newsletterSubcription.email'=>'required',

        ];

    public function mount()
    {
        $this->newsletterSubcription=new NewsletterSubcription();
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->newsletterSubcription=NewsletterSubcription::find($id);
        }
        else{
            $this->newsletterSubcription=new NewsletterSubcription();
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
        $this->newsletterSubcription->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'NewsletterSubcription saved successfully.']);
    }

    public function delete($id)
    {
        NewsletterSubcription::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'NewsletterSubcription deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.newsletter-subcription-component',['newsletterSubcriptions'=>NewsletterSubcription::latest()->paginate(10)]);
    }
}
