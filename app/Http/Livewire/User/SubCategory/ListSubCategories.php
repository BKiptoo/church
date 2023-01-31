<?php

namespace App\Http\Livewire\User\SubCategory;

use App\Http\Controllers\SystemController;
use App\Models\SubCategory;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListSubCategories extends Component
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
        $model = SubCategory::query()
            ->with(['media'])
            ->findOrFail($this->model_id);

        // unlink media
        SystemController::removeExistingFiles($model->id, true);

        // then delete
        $model->forceDelete();

        Note::createSystemNotification(
            User::class,
            'Sub Category Deletion',
            'You have successfully deleted sub category'
        );
        $this->alert('success', 'You have successfully deleted sub category');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.sub-category.list-sub-categories', [
            'models' => $this->readyToLoad
                ? SubCategory::query()
                    ->with([
                        'category',
                        'media'
                    ])
                    ->latest('updated_at')
                    ->where(function ($query) {
                        $query->orWhere('name', 'ilike', '%' . $this->search . '%')
                            ->whereRelation('category', 'name', 'ilike', '%' . $this->search . '%')
                            ->whereRelation('category', 'slug', 'ilike', '%' . $this->search . '%')
                            ->orWhere('slug', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
