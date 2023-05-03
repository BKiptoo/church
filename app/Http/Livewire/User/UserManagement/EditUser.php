<?php

namespace App\Http\Livewire\User\UserManagement;

use App\Models\Country;
use App\Models\User;
use App\Models\UserCountryAccess;
use App\Traits\SysPermissions;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditUser extends Component
{
    use FindGuard, SysPermissions, LivewireAlert, WithFileUploads;

    public $user;
    public $name;
    public $country_id;
    public $phoneNumber;
    public $email;
    public $position;
    public $accessRoles = [];
    public $accessCountries = [];

    public $search;
    public $isActive;
    public $validatedData;

    protected $queryString = ['search'];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function mount(string $slug)
    {
        $this->user = User::query()
            ->with([
                'userCountriesAccess'
            ])
            ->firstWhere('slug', $slug);
        if (!$this->user) {
            return redirect()->route('list.users');
        } else {
            $this->country_id = $this->user->country_id;
            $this->name = $this->user->name;
            $this->phoneNumber = $this->user->phoneNumber;
            $this->email = $this->user->email;
            $this->position = $this->user->position;
            $this->isActive = $this->user->isActive;

            // autofill the roles
            foreach ($this->user->getPermissionNames() as $permissionName) {
                $this->accessRoles[] = $permissionName;
            }

            // autofill the countries
            foreach ($this->user->userCountriesAccess as $countriesAccess) {
                $this->accessCountries[] = $countriesAccess->country_id;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phoneNumber' => ['required', 'numeric'],
            'isActive' => ['required'],
        ];
    }

    /**
     * @param $propertyName
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function linkOrRemovePrivilege(string $privilege)
    {
        // check if it exists in array
        if (in_array($privilege, $this->accessRoles)) {
            unset($this->accessRoles[array_search($privilege, $this->accessRoles)]);
            if ($this->user->hasPermissionTo($privilege)) {
                $this->user->revokePermissionTo($privilege);
                $this->user->refresh();
                $this->emit('noteAdded');
                $this->alert('warning', 'Revoked privilege ' . $privilege);
            }
        } else {
            $this->accessRoles[] = $privilege;
            $this->user->givePermissionTo($privilege);
            $this->user->refresh();
            $this->emit('noteAdded');
            $this->alert('info', 'Granted privilege ' . $privilege);
        }
    }

    public function linkOrRemoveCountry(string $countryId)
    {
        // check if it exists in array
        if (in_array($countryId, $this->accessCountries)) {
            unset($this->accessRoles[array_search($countryId, $this->accessCountries)]);
            // remove it for userCountriesAccess
            $countryAccess = $this->user->userCountriesAccess->where('country_id', $countryId)->first();
            if ($countryAccess) {
                $countryAccess->forceDelete();
                $this->user->refresh();
                $this->alert('warning', 'Removed access from country ' . $countryAccess->country->name);
            }
        } else {
            $this->accessCountries[] = $countryId;
            $countryAccess = UserCountryAccess::query()->create([
                'user_id' => $this->user->id,
                'country_id' => $countryId
            ]);
            $this->user->refresh();
            $this->alert('info', 'Granted access for country ' . $countryAccess->country->name);
        }
    }

    /**
     * update user password here
     */
    public function submit()
    {
        $this->validatedData = $this->validate();
        $this->confirm('Are you sure you want to proceed?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, I am sure!',
            'cancelButtonText' => 'No, cancel it!',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
    }

    public function confirmed()
    {
        $this->user->fill($this->validatedData);
        if ($this->user->isClean()) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        $this->user->save();
        Note::createSystemNotification(
            User::class,
            'User Account Update', 'You have successfully updated user ' . $this->name . ' and granted ' . count($this->accessRoles) . ' privileges.'
        );
        $this->alert('success', 'You have successfully updated user ' . $this->name . ' and granted ' . count($this->accessRoles) . ' privileges.');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.user-management.edit-user', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->where(function ($query) {
                    $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                })
                ->limit(18)
                ->get() : [],
            'countriesList' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->get() : [],
            'permissions' => $this->readyToLoad ? $this->permissions() : []
        ]);
    }
}
