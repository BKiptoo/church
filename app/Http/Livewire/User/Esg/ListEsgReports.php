<?php

namespace App\Http\Livewire\User\Esg;

use App\Http\Controllers\SystemController;
use App\Models\Esg;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListEsgReports extends Component
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
        $esg = Esg::query()
            ->with(['media'])
            ->findOrFail($this->model_id);

        // unlink media
        SystemController::removeExistingFiles($esg->id, true);

        // then delete
        $esg->forceDelete();

        Note::createSystemNotification(
            User::class,
            'Esg Report Deletion',
            'You have successfully deleted esg report'
        );
        $this->alert('success', 'You have successfully deleted esg report');
    }

    public function download(string $fileName)
    {
        // check if feature_image exists
        $path ??= 'csquared';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        return Storage::disk('do_space_cdn')->download($path . '/' . $fileName);
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.esg.list-esg-reports', [
            'models' => $this->readyToLoad
                ? Esg::query()
                    ->with([
                        'media'
                    ])
                    ->latest('updated_at')
                    ->where(function ($query) {
                        $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                            ->orWhere('description', 'ilike', '%' . $this->search . '%')
                            ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
