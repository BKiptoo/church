<?php

namespace App\Http\Livewire\User\Products;

use App\Http\Controllers\SystemController;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddProduct extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads, SharedProcess;

    public $country_id;
    public $category_id;
    public $sub_category_id;
    public $name;
    public $photo;
    public $description;
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
            'country_id' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['file', 'image', 'max:15000', 'nullable'] // 5MB Max
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
        $model = Product::query()->create($this->validatedData);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $model->id,
                Product::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Product',
            'Successfully added new product.'
        );
        $this->alert('success', 'Successfully added new product.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.products.add-product', [
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
