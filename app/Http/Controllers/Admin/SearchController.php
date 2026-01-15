<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Branch;

class SearchController extends Controller
{
    public function products(Request $request)
    {
        $term = $request->get('q');
        $products = Product::where('status', 'active')
            ->where(function($query) use ($term) {
                $query->where('name', 'LIKE', "%$term%")
                    ->orWhere('sku', 'LIKE', "%$term%");
            })
            ->limit(10)
            ->get(['id', 'name', 'sku', 'selling_price']);

        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'text' => $product->name . ' (' . $product->sku . ') - $' . number_format($product->selling_price, 2),
                'price' => $product->selling_price,
            ];
        }));
    }

    public function customers(Request $request)
    {
        $term = $request->get('q');
        $customers = Customer::where('name', 'LIKE', "%$term%")
            ->orWhere('phone', 'LIKE', "%$term%")
            ->limit(10)
            ->get(['id', 'name', 'phone']);

        return response()->json($customers->map(function($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->name . ($customer->phone ? ' (' . $customer->phone . ')' : ''),
            ];
        }));
    }

    public function suppliers(Request $request)
    {
        $term = $request->get('q');
        $suppliers = Supplier::where('status', 'active')
            ->where(function($query) use ($term) {
                $query->where('name', 'LIKE', "%$term%")
                    ->orWhere('phone', 'LIKE', "%$term%");
            })
            ->limit(10)
            ->get(['id', 'name', 'phone']);

        return response()->json($suppliers->map(function($supplier) {
            return [
                'id' => $supplier->id,
                'text' => $supplier->name . ($supplier->phone ? ' (' . $supplier->phone . ')' : ''),
            ];
        }));
    }

    public function categories(Request $request)
    {
        $term = $request->get('q');
        $categories = Category::where('name', 'LIKE', "%$term%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($categories->map(function($category) {
            return [
                'id' => $category->id,
                'text' => $category->name,
            ];
        }));
    }

    public function branches(Request $request)
    {
        $term = $request->get('q');
        $branches = Branch::where('name', 'LIKE', "%$term%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($branches->map(function($branch) {
            return [
                'id' => $branch->id,
                'text' => $branch->name,
            ];
        }));
    }
}
