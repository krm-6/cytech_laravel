<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index() {
        $products=products::all();
        return view('products.index', compact('products'));
    }
    public function detail(string $id) {
        $product=products::find($id);
        $company=$product->company;
        return view('products.detail', compact('product', 'company'));
    }
}
