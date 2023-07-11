<?php

namespace App\Http\Livewire\User\Faqs;

use App\Models\Faq;
use App\Models\User;
use App\Traits\SharedProcess;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListFaqs extends Component
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
        $faq = Faq::query()
            ->with(['media'])
            ->findOrFail($this->model_id);

        // then delete
        $faq->forceDelete();

        Note::createSystemNotification(
            User::class,
            'Faq Deletion',
            'You have successfully deleted faq'
        );
        $this->alert('success', 'You have successfully deleted faq');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.faqs.list-faqs', [
            'models' => $this->readyToLoad
                ? Faq::query()
                    ->with([
                        'country'
                    ])
                    ->latest('updated_at')
                    ->whereIn('country_id',
                        $this->worldAccess()
                    )
                    ->where(function ($query) {
                        $query->orWhere('question', 'ilike', '%' . $this->search . '%')
                            ->orWhere('answer', 'ilike', '%' . $this->search . '%')
                            ->orWhereRelation('country', 'name', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
