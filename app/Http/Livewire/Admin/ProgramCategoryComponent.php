<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProgramCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProgramCategoryComponent extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public ProgramCategory $programCategory;
    public $editableMode=false;
    public $icon;

    protected $rules=[
        'programCategory.title'=>'required',
        'programCategory.meta_title'=>'nullable',
        'programCategory.meta_description'=>'nullable',
        'programCategory.slug'=>'required',
        'programCategory.short_desc'=>'required|string',
        ];

    public function mount()
    {
        $this->programCategory=new ProgramCategory();
    }

    public function updatedProgramCategoryTitle($title){
        $this->programCategory->slug=Str::slug($title);
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $this->programCategory=ProgramCategory::find($id);
        }
        else{
            $this->programCategory=new ProgramCategory();
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
        if (!empty($this->icon)) {
            #move image to property folder
            $saved_image_path = 'storage/' . $this->icon->store('categories', 'public');
            #save image path to db
            $this->programCategory->icon=$saved_image_path;
        }
        $this->programCategory->save();
        $this->editableMode=false;
        $this->icon=null;
        $this->dispatchBrowserEvent('success-notification',['message'=>'ProgramCategory saved successfully.']);
    }

    public function delete($id)
    {
        ProgramCategory::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'ProgramCategory deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.program-category-component',['programCategorys'=>ProgramCategory::latest()->paginate(10)]);
    }
}
