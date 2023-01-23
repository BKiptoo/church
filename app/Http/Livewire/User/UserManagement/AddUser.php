<?php

namespace App\Http\Livewire\User\UserManagement;

use App\Jobs\MailJob;
use App\Models\Country;
use App\Models\User;
use App\Models\UserCountryAccess;
use App\Traits\SysPermissions;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Note\Note;

class AddUser extends Component
{
    use FindGuard, LivewireAlert, SysPermissions;

    public $name;
    public $country_id;
    public $phoneNumber;
    public $email;
    public $position;
    public $accessRoles = [];
    public $accessCountries = [];

    public $search;

    protected $queryString = ['search'];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phoneNumber' => ['required', 'numeric', 'unique:users'],
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

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function linkOrRemovePrivilege(string $privilege)
    {
        // check if it exists in array
        if (in_array($privilege, $this->accessRoles)) {
            unset($this->accessRoles[array_search($privilege, $this->accessRoles)]);
        } else {
            $this->accessRoles[] = $privilege;
        }
    }

    public function linkOrRemoveCountry(string $countryId)
    {
        // check if it exists in array
        if (in_array($countryId, $this->accessCountries)) {
            unset($this->accessCountries[array_search($countryId, $this->accessCountries)]);
        } else {
            $this->accessCountries[] = $countryId;
        }
    }

    public function submit()
    {
        $this->validate();
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
        // generate password
        $password = rand(100000, 500000);

        // create user here
        $user = User::query()->create([
            'country_id' => $this->country_id,
            'name' => $this->name,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'position' => $this->position,
            'password' => bcrypt($password),
        ]);

        // assign roles/permissions
        foreach ($this->accessRoles as $permission) {
            $user->givePermissionTo($permission);
        }

        // assign countries
        foreach ($this->accessCountries as $countryId) {
            UserCountryAccess::query()->create([
                'user_id' => $user->id,
                'country_id' => $countryId
            ]);
        }

        // send user account credentials
        dispatch(new MailJob(
            $this->name,
            $this->email,
            config('app.name') . ' User Account',
            'Your account has been activated, kindly use ' . $password . ' as your password to login.',
            true,
            route('login'),
            'CHECK ACCOUNT'
        ))->onQueue('emails')->delay(1);

        Note::createSystemNotification(
            User::class,
            'New User Account',
            'You have successfully created user ' . $this->name . ' and granted ' . count($this->accessRoles) . ' privileges.'
        );
        $this->alert('success', 'You have successfully created user ' . $this->name . ' and granted ' . count($this->accessRoles) . ' privileges.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.user-management.add-user', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->where(function ($query) {
                    $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                })
                ->limit(10)
                ->get() : [],
            'countriesList' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->get() : [],
            'permissions' => $this->permissions()
        ]);
    }
}
