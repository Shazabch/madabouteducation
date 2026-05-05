<?php

namespace App\Http\Livewire\Admin;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class MediaComponent extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public Media $media;
    public $image;
    public $editableMode=false;

    protected $rules=[
        'media.title'=>'required',
        'media.image'=>'nullable',
        'media.link'=>'required',
        'media.status' => 'nullable',


        ];

    public function mount()
    {
        $this->media=new Media();
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->media=Media::find($id);
        }
        else{
            $this->media=new Media();
        }
        $this->editableMode=true;
    }

    public function cancelEdit()
    {
        $this->editableMode=false;
    }

    public function save()
    {

$this->media->status = $this->media->status ? true : false;
        $this->validate();
        if($this->image){
            $saved_image_path = 'storage/' . $this->image->store('media', 'public');
            deleteFile($this->media->image);
            $this->media->image=$saved_image_path;
        }
        $this->media->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Media saved successfully.']);
    }

    public function delete($id)
    {
        deleteFile(Media::where('id',$id)->value('image'));
        Media::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Media deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.media-component',['medias'=>Media::latest()->paginate(10)]);
    }
}
