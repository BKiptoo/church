<?php

namespace App\Http\Livewire\User\Careers\Job;

use App\Models\JobApplication;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListJobApplications extends Component
{
    use WithPagination, LivewireAlert;

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
        JobApplication::query()->findOrFail($this->model_id)->forceDelete();
        Note::createSystemNotification(
            User::class,
            'Job Application Deletion',
            'You have successfully deleted job application'
        );
        $this->alert('success', 'You have successfully deleted job application');
    }

    public function close(string $id)
    {
        $applications = JobApplication::query()->findOrFail($id);
        $applications->update([
            'isClosed' => true
        ]);
        $this->alert('success', 'You have successfully closed job application');
    }

    public function pass(string $id)
    {
        $applications = JobApplication::query()->findOrFail($id);
        $applications->update([
            'isClosed' => true,
            'isPassed' => true
        ]);
        $this->alert('success', 'You have successfully marked as pass for job application');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.careers.job.list-job-applications', [
            'models' => $this->readyToLoad
                ? JobApplication::query()
                    ->with([
                        'career.country',
                        'media'
                    ])
                    ->latest()
                    ->where(function ($query) {
                        $query->orWhere('linkedInUrl', 'ilike', '%' . $this->search . '%')
                            ->orWhere('phoneNumber', 'ilike', '%' . $this->search . '%')
                            ->orWhere('email', 'ilike', '%' . $this->search . '%')
                            ->orWhere('firstName', 'ilike', '%' . $this->search . '%')
                            ->orWhere('lastName', 'ilike', '%' . $this->search . '%')
                            ->whereRelation('career', 'name', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
