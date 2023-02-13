<?php

namespace App\Http\Livewire\User\Contact;

use App\Models\Contact;
use App\Traits\SharedProcess;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ListContacts extends Component
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

    public function render()
    {
        return view('livewire.user.contact.list-contacts', [
            'models' => $this->readyToLoad
                ? Contact::query()
                    ->with(['country'])
                    ->latest('updated_at')
                    ->whereIn('country_id',
                        $this->worldAccess()
                    )
                    ->where(function ($query) {
                        $query->orWhere('firstName', 'ilike', '%' . $this->search . '%')
                            ->orWhere('email', 'ilike', '%' . $this->search . '%')
                            ->orWhere('phoneNumber', 'ilike', '%' . $this->search . '%')
                            ->orWhere('lastName', 'ilike', '%' . $this->search . '%');
                    })
                    ->where('isClosed', false)
                    ->paginate(10)
                : []
        ]);
    }
}
