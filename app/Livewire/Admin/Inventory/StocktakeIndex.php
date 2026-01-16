<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Stocktake;
use App\Models\Store;

class StocktakeIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; // '' = all, 'draft', 'pending_approval', 'completed', 'rejected'
    public $store_id = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function filterByStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $query = Stocktake::with(['store', 'creator', 'approver'])
            ->when($this->search, function ($q) {
                $q->where('reference', 'like', '%' . $this->search . '%')
                  ->orWhereHas('store', fn ($sq) => $sq->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->store_id, function ($q) {
                $q->where('store_id', $this->store_id);
            })
            ->latest();

        $stocktakes = $query->paginate(10);
        $stores = Store::all();

        return view('livewire.admin.inventory.stocktake-index', compact('stocktakes', 'stores'));
    }
}
