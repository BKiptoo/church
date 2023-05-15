<?php

namespace App\Http\Livewire\User\SubCategory;

use App\Http\Controllers\SystemController;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditSubCategory extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $category_id;
    public $name;
    public $photo;
    public $validatedData;

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
        $this->model = SubCategory::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.categories');
        } else {
            $this->category_id = $this->model->category_id;
            $this->name = $this->model->name;
        }
    }

    protected function rules(): array
    {
        return [
            'category_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['file', 'image', 'max:5096', 'nullable'] // 5MB Max
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

    /**
     * update model password here
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
        $this->model->fill($this->validatedData);
        if ($this->model->isClean() && $this->photo === null) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $this->model->id,
                SubCategory::class,
                $this->photo
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Sub Category',
            'Successfully updated su category.'
        );
        $this->alert('success', 'Successfully updated sub category.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.sub-category.edit-sub-category', [
            'categories' => $this->readyToLoad ? Category::query()
                ->orderBy('name')
                ->get() : []
        ]);
    }
}
