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

    public function edit(string $id) {
        $product=products::find($id);
        $company=$product->company;
        return view('products.edit', compact('product', 'company'));
    }
        /**
     * 削除処理
     */
    public function destroy($id)
    {
        // Productsテーブルから指定のIDのレコード1件を取得
        $product = Products::find($id);
        // レコードを削除
        $product->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect()->route('products.index');
    }

    public function edit_page($id)
    {
        // IDに基づいて投稿を取得
        $product = Products::findOrFail($id);
        // 投稿データをedit.blade.phpに渡す
        return view('products.edit', compact('product'));
    }

    public function search(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');
        if ($keyword) {
            $products = Products::where('product_name', 'like', "%{$keyword}%")
                         ->get();
        } else {
            // すべての投稿を取得
            $products = Products::all();
        }
        // ビューに検索結果を渡す
        return view('products.index', compact('products'));
    }

}
