<?php

namespace App\Http\Livewire\User\Orders;

use App\Models\Order;
use App\Models\User;
use App\Traits\SharedProcess;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Note\Note;

class ListOrders extends Component
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
        $model = Order::query()
            ->findOrFail($this->model_id);

        if (is_null($model->summary)) {
            $this->alert('warning', 'An order has to have a summery to be closed.');
        } else {
            // then delete
            $model->update([
                'isClosed' => true
            ]);

            Note::createSystemNotification(
                User::class,
                'Order Marked As Closed',
                'You have successfully closed the order.'
            );
            $this->alert('success', 'You have successfully closed the order.');
        }
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.orders.list-orders', [
            'models' => $this->readyToLoad
                ? Order::query()
                    ->with([
                        'country',
                        'product'
                    ])
                    ->latest('updated_at')
                    ->whereIn('country_id',
                        $this->worldAccess()
                    )
                    ->where(function ($query) {
                        $query->orWhere('email', 'ilike', '%' . $this->search . '%')
                            ->orWhere('summary', 'ilike', '%' . $this->search . '%')
                            ->orWhereRelation('country', 'name', 'ilike', '%' . $this->search . '%')
                            ->orWhereRelation('product', 'name', 'ilike', '%' . $this->search . '%');
                    })
                    ->paginate(10)
                : []
        ]);
    }
}
