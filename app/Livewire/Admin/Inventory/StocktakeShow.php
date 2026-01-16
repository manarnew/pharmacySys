<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Stocktake;
use App\Models\StocktakeItem;
use App\Models\Inventory;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StocktakeShow extends Component
{
    public Stocktake $stocktake;

    public function mount(Stocktake $stocktake)
    {
        $this->stocktake = $stocktake->load(['items.product', 'store', 'creator', 'approver']);
        
        if (!auth()->user()->can('stocktake_view')) {
            abort(403);
        }
    }

    public function approve()
    {
        if (!auth()->user()->can('stocktake_approve')) {
            session()->flash('error', 'You do not have permission to approve stocktakes.');
            return;
        }

        if ($this->stocktake->status !== 'pending_approval') {
            session()->flash('error', 'This stocktake is not pending approval.');
            return;
        }

        DB::transaction(function () {
            // Apply changes to inventory
            foreach ($this->stocktake->items as $item) {
                if ($item->difference != 0) {
                    $inventory = Inventory::where('store_id', $this->stocktake->store_id)
                        ->where('product_id', $item->product_id)
                        ->where('batch_no', $item->batch_no)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity = $item->actual_quantity;
                        $inventory->save();

                        // Record movement
                        StockMovement::create([
                            'product_id' => $item->product_id,
                            'store_id' => $this->stocktake->store_id,
                            'type' => 'adjustment',
                            'reference_type' => Stocktake::class,
                            'reference_id' => $this->stocktake->id,
                            'batch_no' => $item->batch_no,
                            'quantity_in' => $item->difference > 0 ? $item->difference : 0,
                            'quantity_out' => $item->difference < 0 ? abs($item->difference) : 0,
                            'balance' => $inventory->quantity,
                            'notes' => 'Stocktake Adjustment: ' . $this->stocktake->reference,
                            'created_by' => auth()->id(),
                        ]);
                    }
                }
            }

            $this->stocktake->update([
                'status' => 'completed',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        session()->flash('success', 'Stocktake approved and inventory updated successfully.');
    }

    public function reject()
    {
        if (!auth()->user()->can('stocktake_approve')) {
            session()->flash('error', 'You do not have permission to reject stocktakes.');
            return;
        }

        $this->stocktake->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(), // Recorded as 'approver' even for rejection
            'approved_at' => now(),
        ]);

        session()->flash('success', 'Stocktake rejected.');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.inventory.stocktake-show');
    }
}
