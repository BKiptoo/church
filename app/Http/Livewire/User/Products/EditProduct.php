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

class EditProduct extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $country_id;
    public $category_id;
    public $sub_category_id;
    public $name;
    public $photo;
    public $cost;
    public $description;
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
        $this->model = Product::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.products');
        } else {
            $this->category_id = $this->model->category_id;
            $this->sub_category_id = $this->model->sub_category_id;
            $this->country_id = $this->model->country_id;
            $this->name = $this->model->name;
            $this->cost = $this->model->cost;
            $this->description = $this->model->description;
        }
    }

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
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
                Product::class,
                $this->photo
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Product',
            'Successfully updated product.'
        );
        $this->alert('success', 'Successfully updated product.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.products.edit-product', [
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
