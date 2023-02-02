<?php

namespace App\Http\Livewire\User\Blogs;

use App\Http\Controllers\SystemController;
use App\Models\Category;
use App\Models\Country;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddPost extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads, SharedProcess;

    public $country_id;
    public $category_id;
    public $sub_category_id;
    public $name;
    public $photo;
    public $description;

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
            'country_id' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
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

    public function submit()
    {
        $this->validate();
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
        $model = Post::query()->create([
            'country_id' => $this->country_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'user_id' => $this->findGuardType()->id(),
            'name' => $this->name,
            'description' => $this->description
        ]);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $model->id,
                Post::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Post',
            'Successfully added post.'
        );
        $this->alert('success', 'Successfully added post.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.blogs.add-post', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
            'categories' => $this->readyToLoad ? Category::query()
                ->orderBy('name')
                ->get() : [],
            'subCategories' => $this->readyToLoad ? SubCategory::query()
                ->where('category_id', $this->category_id)
                ->orderBy('name')
                ->get() : []
        ]);
    }
}
