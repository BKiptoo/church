<?php

namespace App\Http\Livewire\User\UserManagement;

use App\Models\User;
use App\Traits\SharedProcess;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListUsers extends Component
{
    use WithPagination, LivewireAlert, SharedProcess;

    public $search;
    public $model_id;

    protected $queryString = ['search'];

    protected string $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    /**
     * update model password here
     */
    public function delete(string $id)
    {
        $this->model_id = $id;
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
        User::query()->findOrFail($this->model_id)->delete();
        Note::createSystemNotification(
            User::class,
            'User Deletion',
            'You have successfully deleted user'
        );
        $this->alert('success', 'You have successfully deleted user');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    /**
     * @throws Exception
     */
    public function render()
    {
        return view('livewire.user.user-management.list-users', [
            'models' => $this->readyToLoad
                ? User::query()
                    ->with([
                        'country',
                        'media'
                    ])
                    ->latest('updated_at')
                    ->whereIn('country_id',
                        $this->worldAccess()
                    )
                    ->where(function ($query) {
                        $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                            ->orWhere('phoneNumber', 'ilike', '%' . $this->search . '%')
                            ->orWhere('email', 'ilike', '%' . $this->search . '%')
                            ->orWhere('position', 'ilike', '%' . $this->search . '%')
                            ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
