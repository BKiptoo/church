<?php

namespace App\Http\Livewire\User\Impact;

use App\Http\Controllers\SystemController;
use App\Models\Impact;
use App\Models\User;
use App\Traits\SharedProcess;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListImpact extends Component
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
        $event = Impact::query()
            ->with(['media'])
            ->findOrFail($this->model_id);

        // unlink media
        SystemController::removeExistingFiles($event->id, true);

        // then delete
        $event->forceDelete();

        Note::createSystemNotification(
            User::class,
            'Impact Deletion',
            'You have successfully deleted impact'
        );
        $this->alert('success', 'You have successfully deleted impact');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.impact.list-impact', [
            'models' => $this->readyToLoad
                ? Impact::query()
                    ->with([
                        'impactType'
                    ])
                    ->latest()
                    ->where(function ($query) {
                        $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                            ->orWhere('description', 'ilike', '%' . $this->search . '%')
                            ->whereRelation('impactType', 'name', 'ilike', '%' . $this->search . '%')
                            ->whereRelation('impactType', 'slug', 'ilike', '%' . $this->search . '%')
                            ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
