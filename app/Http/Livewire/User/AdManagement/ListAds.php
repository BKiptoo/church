<?php

namespace App\Http\Livewire\User\AdManagement;

use App\Http\Controllers\SystemController;
use App\Models\Ad;
use App\Models\User;
use App\Traits\SharedProcess;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListAds extends Component
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
        $ad = Ad::query()
            ->with(['media'])
            ->findOrFail($this->model_id);

        // unlink media
        SystemController::removeExistingFiles($ad->id, true);

        // then delete
        $ad->forceDelete();

        Note::createSystemNotification(
            User::class,
            'Ad Deletion',
            'You have successfully deleted ad'
        );
        $this->alert('success', 'You have successfully deleted ad');
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
        return view('livewire.user.ad-management.list-ads', [
            'models' => $this->readyToLoad
                ? Ad::query()
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
                            ->orWhere('linkUrl', 'ilike', '%' . $this->search . '%')
                            ->orWhere('buttonName', 'ilike', '%' . $this->search . '%')
                            ->orWhere('description', 'ilike', '%' . $this->search . '%')
                            ->orWhereRelation('country', 'name', 'ilike', '%' . $this->search . '%')
                            ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
