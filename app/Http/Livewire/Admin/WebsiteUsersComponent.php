<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class WebsiteUsersComponent extends Component
{
    use WithPagination,AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.admin.website-users-component',['users'=>User::where('is_admin','0')->latest()->paginate(10)]);
    }
}
