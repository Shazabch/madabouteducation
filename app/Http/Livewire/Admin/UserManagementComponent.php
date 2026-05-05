<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class UserManagementComponent extends Component
{
    use WithPagination,AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    public User $user;
    public $password;
    public $allRoles=[];
    public $selectedRole;
    public $editableMode=false;
    public bool $isNewUser=false;

    protected function rules(){
        return [
        'user.name'=>'required',
        'user.email'=>'required',
        'password'=>Rule::requiredIf($this->isNewUser),
        ];
    }

    public function mount()
    {
        $this->user=new User();
        $this->allRoles=Role::all();
    }

    public function createOrEdit($id=null)
    {
        $this->selectedRole=null;
        if($id)
        {
            $this->user=User::find($id);
            $this->isNewUser=false;
            $this->selectedRole=$this->user->getRoleNames()->first();
        }
        else{
            $this->user=new User();
            $this->isNewUser=true;
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
        if($this->isNewUser){
            $this->authorize('user-management');
            $this->user->password=Hash::make($this->password);
            $this->user->save();
        }else{
            $this->authorize('user-management');
            $this->user->save();
        }
        $this->user->syncRoles($this->selectedRole);
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'User saved successfully.']);
    }

    public function delete($id)
    {
        $this->authorize('user-management');
        User::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'User deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.admin.user-management-component',['users'=>User::where('is_admin','1')->latest()->paginate(10)]);
    }
}
