<?php

namespace App\Http\Livewire\User\SubCategory;

use App\Http\Controllers\SystemController;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddSubCategory extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads;

    public $category_id;
    public $name;
    public $photo;
    public $validatedData;

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    protected function rules(): array
    {
        return [
            'category_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['mimes:jpg,jpeg,png,bmp,gif,svg,webp', 'max:15000', 'nullable'] // 5MB Max
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
        // create here
        $model = SubCategory::query()->create($this->validatedData);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $model->id,
                SubCategory::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Sub Category',
            'Successfully added new sub category.'
        );
        $this->alert('success', 'Successfully added new sub category.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.sub-category.add-sub-category', [
            'categories' => $this->readyToLoad ? Category::query()
                ->orderBy('name')
                ->get() : []
        ]);
    }
}
