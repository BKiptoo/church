<?php

namespace App\Http\Livewire\User\Account;

use App\Traits\SysPermissions;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class RoleSetting extends Component
{
    use FindGuard, SysPermissions;

    public $user;
    public $access = [];

    public function mount()
    {
        $this->user = $this->findGuardType()->user();
        foreach ($this->user->getPermissionNames() as $permissionName) {
            $this->access[] = $permissionName;
        }
    }

    public function render()
    {
        return view('livewire.user.account.role-setting', [
            'permissions' => $this->permissions()
        ]);
    }
}
