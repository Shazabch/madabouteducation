<?php

namespace App\Http\Livewire\Admin;

use App\Models\CarouselImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CarouselComponent extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public CarouselImage $carousel;
    public $image;
    public $editableMode = false;

    protected function rules()
    {
        return [
            'carousel.title' => 'nullable',
            'carousel.description' => 'nullable',
            'carousel.order' => 'required|integer',
            'carousel.status' => 'nullable',
            'image' => $this->carousel->id ? 'nullable|image|max:2048' : 'required|image|max:2048'
        ];
    }

    public function mount()
    {
        $this->carousel = new CarouselImage();
        $this->carousel->status = true; // Set default status to active for new records
    }

    public function createOrEdit($id = null)
    {
        if ($id) {
            $this->carousel = CarouselImage::find($id);
        } else {
            $this->carousel = new CarouselImage();
            $this->carousel->order = CarouselImage::max('order') + 1;
            $this->carousel->status = true; // Set default status to active for new records
        }
        $this->editableMode = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            if ($this->carousel->image) {
                deleteFile($this->carousel->image);
            }
            $this->carousel->image = 'storage/' . $this->image->store('carousel', 'public');
            $this->image = null;
        }

        $this->carousel->status = $this->carousel->status ? true : false;
        $this->carousel->save();

        $this->editableMode = false;
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Carousel image saved successfully.']);
    }

    public function delete($id)
    {
        $carousel = CarouselImage::find($id);
        if ($carousel->image) {
            deleteFile($carousel->image);
        }
        $carousel->delete();
        $this->dispatchBrowserEvent('success-notification', ['message' => 'Carousel image deleted successfully.']);
    }

    public function cancelEdit()
    {
        $this->editableMode = false;
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.admin.carousel-component', [
            'carouselImages' => CarouselImage::orderBy('order')->paginate(10)
        ]);
    }
}
