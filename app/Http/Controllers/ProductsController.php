<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Companies;

class ProductsController extends Controller
{
    public function index() {
        $products = products::all();
        $companies = companies::all();
        return view('products.index', compact('products', 'companies'));
    }

    public function detail (string $id) {
        $product = products::find($id);
        $company = $product->company;
        return view('products.detail', compact('product', 'company'));
    }

    public function edit(string $id) {
        $product = products::find($id);
        $selected_company = $product->company;
        $companies = companies::all();
        return view('products.edit', compact('product', 'selected_company', 'companies'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        // IDに基づいて投稿を取得
        $product = Products::findOrFail($id);
        $product->update(
            [
                'product_name' => $request->product_name,
                'company_id' => $request->company_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'img_path' => $request->img_path
            ]
        );
        // 投稿データをedit.blade.phpに渡す
        return redirect()->route('products.index');
    }
        /**
     * 削除処理
     */
    public function destroy ($id)
    {
        // Productsテーブルから指定のIDのレコード1件を取得
        $product = Products::find ($id);
        // レコードを削除
        $product->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect()->route('products.index');
    }
    //キーワード検索
    public function search(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');
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

    //新規登録画面を表示
    public function registration()
    {
        $companies = Companies::all();
        //view()の第二引数に$companiesを渡す
        return view('products.registration', compact('companies'));
    }

    // 新規登録処理を行うメソッド
    public function register(Request $request)
    {
        // ユーザーの作成処理
        $this->create($request->all());
        return redirect()->route('products.index');
    }

    protected function create(array $data)
    {
        return Products::create([
            'company_id' => $data['company_id'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'comment' => $data['comment'],
            'img_path' => $data['img_path']
        ]);
    }
}
