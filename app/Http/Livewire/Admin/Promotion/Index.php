<?php

namespace App\Http\Livewire\Admin\Promotion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Promotion;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = 'all'; // all | active | inactive

    protected $updatesQueryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $promo = Promotion::findOrFail($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();
    }

    public function delete($id)
    {
        Promotion::findOrFail($id)->delete();
        session()->flash('message', 'Promotion deleted successfully.');
    }

    public function render()
    {
        $query = Promotion::withCount('usages');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->status === 'active') {
            $query->where('is_active', true);
        } elseif ($this->status === 'inactive') {
            $query->where('is_active', false);
        }

        $promotions = $query->latest()->paginate(10);

        return view('livewire.admin.promotion.index', compact('promotions'));
    }
}
