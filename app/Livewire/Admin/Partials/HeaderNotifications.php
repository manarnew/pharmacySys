<?php

namespace App\Livewire\Admin\Partials;

use Livewire\Component;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Collection;

class HeaderNotifications extends Component
{
    public function getNotificationsProperty(): Collection
    {
        $notifications = collect();

        // 1. Low Stock Alerts
        $lowStockProducts = Product::with('inventories')->get()->filter(function ($product) {
            return $product->total_stock <= $product->reorder_level;
        });

        foreach ($lowStockProducts as $product) {
            $notifications->push([
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => "{$product->name} is running low ({$product->total_stock} left).",
                'icon' => '📦',
                'color' => 'yellow',
                'time' => now(), // Static time for now, or track last movement
                'route' => route('admin.products.show', ['product_id' => $product->id]),
            ]);
        }

        // 2. Expiring Soon (Next 3 months)
        $expiringBatches = Inventory::with('product')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addMonths(3))
            ->get();

        foreach ($expiringBatches as $batch) {
            $daysLeft = now()->diffInDays($batch->expiry_date);
            $notifications->push([
                'type' => 'expiring',
                'title' => 'Product Expiring Soon',
                'message' => "{$batch->product->name} (Batch: {$batch->batch_no}) expires in {$daysLeft} days.",
                'icon' => '⏳',
                'color' => 'orange',
                'time' => $batch->updated_at,
                'route' => route('admin.inventory.index'),
            ]);
        }

        // 3. Expired
        $expiredBatches = Inventory::with('product')
            ->where('expiry_date', '<=', now())
            ->get();

        foreach ($expiredBatches as $batch) {
            $notifications->push([
                'type' => 'expired',
                'title' => 'Product Expired',
                'message' => "{$batch->product->name} (Batch: {$batch->batch_no}) has expired!",
                'icon' => '⚠️',
                'color' => 'red',
                'time' => $batch->expiry_date,
                'route' => route('admin.inventory.index'),
            ]);
        }

        // Sort by "urgency" (Expired > Low Stock > Expiring) - simplistic approach
        return $notifications->sortByDesc(function ($n) {
            return match($n['type']) {
                'expired' => 3,
                'low_stock' => 2,
                'expiring' => 1,
                default => 0,
            };
        });
    }

    public function render()
    {
        return view('livewire.admin.partials.header-notifications');
    }
}
