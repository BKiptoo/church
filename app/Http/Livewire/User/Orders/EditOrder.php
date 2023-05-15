<?php

namespace App\Http\Livewire\User\Orders;

use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditOrder extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $country_id;
    public $product_id;
    public $email;
    public $summary;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function mount(string $id)
    {
        $this->model = Order::query()->findOrFail($id);
        if (!$this->model) {
            return redirect()->route('list.orders');
        } else {
            $this->country_id = $this->model->country_id;
            $this->product_id = $this->model->product_id;
            $this->email = $this->model->email;
            $this->summary = $this->model->summary;
        }
    }

    protected function rules(): array
    {
        return [
            'summary' => ['required', 'string']
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
        $this->model->fill([
            'summary' => $this->summary
        ]);
        if ($this->model->isClean()) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Order ' . $this->model->orderNumber,
            'Successfully updated order.'
        );
        $this->alert('success', 'Successfully updated order ' . $this->model->orderNumber);
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.orders.edit-order', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
            'products' => $this->readyToLoad ? Product::query()
                ->orderBy('name')
                ->get() : [],
        ]);
    }
}
