<?php

namespace App\Http\Livewire\Admin;

use App\Mail\ContactFormNotification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactUsComponent extends Component
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $comments;


    public function submitForm()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'comments' => 'required|string',
        ]);

        $emailData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'comments' => $this->comments,
        ];

        Mail::to('enquiry@madabouteducation.com')->send(new ContactFormNotification($emailData));
        $this->reset();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Your message has been sent successfully!']);
    }


    public function render()
    {
        return view('livewire.admin.contact-us-component');
    }
}
