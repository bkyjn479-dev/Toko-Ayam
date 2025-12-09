<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $q = request()->input('q');

        $query = Product::where('stock', '>', 0);

        if ($q) {
            $query->where(function($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $query->paginate(12)->appends(request()->only('q'));

        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        if ($product->stock <= 0) {
            abort(404, 'Product out of stock');
        }
        return view('shop.show', compact('product'));
    }
}
