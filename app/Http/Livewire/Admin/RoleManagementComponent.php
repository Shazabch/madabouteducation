<?php

namespace App\Http\Livewire\Admin;

use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleManagementComponent extends Component
{
    use WithPagination,AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    public Role $role;
    public $editableMode=false;
    public $allPermissions;
    public $selectedPermissions=[];

    protected $rules=[
        'role.name'=>'required',        
        ];

    public function mount()
    {
        $this->role=new Role();
        $this->allPermissions=Permission::all();
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->role=Role::find($id);
            $this->selectedPermissions=$this->role->permissions->pluck('id');
        }
        else{
            $this->role=new Role();
            $this->selectedPermissions=[];
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
        $this->role->save();
        $this->role->syncPermissions($this->selectedPermissions);
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Role saved successfully.']);
    }

    public function delete($id)
    {
        $this->authorize('role-management');
        Role::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Role deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.role-management-component',['roles'=>Role::latest()->paginate(10)]);
    }
}
