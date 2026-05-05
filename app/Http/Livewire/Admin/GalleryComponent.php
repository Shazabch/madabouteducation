<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class GalleryComponent extends Component
{
    use WithFileUploads;
    public $images=[];
    public $newImages=[];

    public function mount(){
        $this->getImages();
    }

    public function saveImages(){
        if (!empty($this->newImages)) {
            foreach ($this->newImages as $photo) {
                #move photos to gallery
                $photo->store('gallery', 'public');
            }
            $this->newImages = [];
            $this->dispatchBrowserEvent('success-notification',['message'=>'Images Saved Successfully!']);
            $this->dispatchBrowserEvent('clear-filepond-files');
            $this->getImages();
        }else{
            $this->dispatchBrowserEvent('error-notification',['message'=>'No Images!']);
        }
    }

    public function getImages(){
        $path=public_path('storage/gallery');
        $this->images= [];
        foreach (glob($path."/*.{jpeg,jpg,png,webp}",GLOB_BRACE) as $file) {
            $this->images[] ='storage/gallery/'.pathinfo($file, PATHINFO_BASENAME);
        }
    }

    public function removePhoto($path){
        deleteFile($path);
        $this->getImages();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Images Deleted Successfully!']);

    }

    public function render()
    {
        return view('livewire.admin.gallery-component');
    }
}
