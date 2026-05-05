<?php

namespace App\Http\Livewire;

use App\Models\NewsletterSubcription;
use Livewire\Component;

class DoNewsletterSubcriptionComponent extends Component
{

    public NewsletterSubcription $newsletterSubcription;

    protected $rules=[
        'newsletterSubcription.email'=>'required',
        ];

    public function mount()
    {
        $this->newsletterSubcription=new NewsletterSubcription();
    }


    public function save()
    {
        $this->validate();
        NewsletterSubcription::updateOrCreate(['email'=>$this->newsletterSubcription->email],$this->newsletterSubcription->toArray());
        $this->newsletterSubcription=new NewsletterSubcription();
        $this->dispatchBrowserEvent('success-prompt',['message'=>'Successfully Subcribed to Newsletter']);
    }


    public function render()
    {
        return view('livewire.do-newsletter-subcription-component');
    }
}
