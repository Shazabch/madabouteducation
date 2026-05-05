<?php

namespace App\Http\Livewire\Admin;

use App\Models\Form;
use App\Models\Images;
use App\Models\Program;
use App\Models\ProgramCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;


class ProgramComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public Program $program;
    public $editableMode = false;
    public $images = [];
    public $categories = [];
    public $forms = [];

    protected function rules()
    {
        return [
            'program.title' => 'required',
            'program.short_desc' => 'required',
            'program.venue' => 'nullable',
            'program.pick_and_drop' => 'nullable',
            'program.overview' => 'nullable',
            'program.content' => 'nullable',
            'program.slug' => 'required',
            'program.meta_title' => 'nullable',
            'program.meta_description' => 'nullable',
            'program.category_id' => 'required',
            'program.form_id' => 'nullable',
            'program.status' => 'nullable',
            'program.meta_keywords' => 'nullable',
            'program.activities_1' => 'nullable',
            'program.activities_2' => 'nullable',
            'program.activities_3' => 'nullable',
            'program.activities_4' => 'nullable',
            'program.is_sst_applicable' => 'nullable',
            'program.type' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->program = new Program(['status' => 1, 'price' => 0, 'booked_slots' => 0, 'total_slots' => 0]);
        $this->categories = ProgramCategory::all();
        $this->forms = Form::all();
    }

    public function updatedProgramTitle($title)
    {
        $this->program->slug = Str::slug($title);
    }

    public function updatedProgramFormId()
    {
        $this->program->load('form');
    }



    public function createOrEdit($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $this->program = Program::find($id);
        } else {
            $this->program = new Program(['status' => 1, 'price' => 0, 'booked_slots' => 0, 'total_slots' => 0]);
        }
        $this->editableMode = true;
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
    }

    public function save()
    {
        $this->program->status = $this->program->status ? true : false;
        $this->program->is_sst_applicable = $this->program->is_sst_applicable ? true : false;
        $isNewProgram = !(isset($this->program->id) && $this->program->id != null);
        $this->validate();
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                #move image to property folder
                $saved_image_path = 'storage/' . $image->store('programs', 'public');
                #save image path to db
                $this->program->images()->save(new Images([
                    'path' => $saved_image_path,
                ]));
            }
            $this->images = [];
        }
        $this->program->meta_keywords = $this->program->meta_keywords;
        $this->program->save();
        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program saved successfully.']);
        $this->dispatchBrowserEvent('clear-filepond-files');
        if ($isNewProgram) {
            return redirect()->route('admin.programs-groups', $this->program->id);
        }
    }

    public function delete($id)
    {
        Program::destroy($id);
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Program deleted successfully.']);
    }

    public function removePhoto($id)
    {

        $photo = Images::find($id);
        if ($photo) {
            #delete photo
            deleteFile($photo->image_name);
            $photo->delete();
            $this->program->load('images');
            $this->dispatchBrowserEvent('success-notification', ['message' => 'Image Removed Successfully']);
        }
    }

    public function render()
    {
        return view('livewire.admin.program-component', ['programs' => Program::withCount('groups')->orderBy('updated_at', 'DESC')->paginate(10)]);
    }
}
