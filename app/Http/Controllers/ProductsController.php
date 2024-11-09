<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Companies;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index() {
        $companies = companies::all();
        return view('products.index', compact('companies'));
    }
    // 商品詳細画面
    public function detail (string $id) {
        $product = products::find($id);
        $company = $product->company;
        return view('products.detail', compact('product', 'company'));
    }
    // 商品情報編集画面（画面表示）
    public function edit(string $id) {
        $product = products::find($id);
        $selected_company = $product->company;
        $companies = companies::all();
        
        return view('products.edit', compact('product', 'selected_company', 'companies'));
    }
    // 商品情報編集画面（更新処理）
    public function update(ProductsRequest $request)
    {   
            $product_id = $request->input('id');
            $validated_data = $request->validated();
            
            try {
                // IDに基づいて投稿を取得
                $product = Products::findOrFail($product_id);
                $img_path = $request-> img_path ? basename($request->file('img_path')->store('public/Image')) : $product->img_path;
                $product -> updateProduct($validated_data, $img_path);
                // 投稿データをedit.blade.phpに渡す
                return redirect()->route('products.edit', ['id' => $product_id]);
            } catch (\Exception $e) {
                return redirect()->route('products.edit', ['id' => $product_id])->with('error', 'エラーが発生しました。');
            }
    }
        /**
     * 削除処理
     */
    public function destroy(Request $request)
    {
        try {
            Products::deleteProduct($request->input('id'));
            // 削除したら一覧画面にリダイレクト
            return response() -> json();
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'エラーが発生しました');
        }
    }
    //検索
    public function search(Request $request)
    {
        $where = [];
        if ($request->input('product_name')) {
            $where[] = ['product_name', 'like', "%{$request->input('product_name')}%"];
        }
        if ($request->input('company_id')) {
            $where[] = ['company_id', '=', $request->input('company_id')];
        }
        if ($request->input('price_min')) {
            $where[] = ['price', '>=', $request->input('price_min')];
        }
        if ($request->input('price_max')) {
            $where[] = ['price', '<=', $request->input('price_max')];
        }
        if ($request->input('stock_min')) {
            $where[] = ['stock', '>=', $request->input('stock_min')];
        }
        if ($request->input('stock_max')) {
            $where[] = ['stock', '<=', $request->input('stock_max')];
        }
        $products = Products::searchProducts($where);
        return response()->json($products);
    }

    //新規登録画面を表示
    public function registration()
    {
        $companies = Companies::all();
        //view()の第二引数に$companiesを渡す
        return view('products.registration', compact('companies'));
    }

    // 新規登録処理を行うメソッド
    public function register(ProductsRequest $request)
    {   //データのバリデーション
        $validatedData = $request->validated();
        try {
             
            if ($request->img_path) {
                //画像ファイルパスの取得
                $img_path = basename($request->file('img_path')->store('public/Image'));
            } else {
                $img_path = null;
            }
            // 商品の登録処理
            Products::create([
                'product_name' => $validatedData['product_name'],
                'company_id' => $validatedData['company_id'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'comment' => $validatedData['comment'],
                'img_path' => $img_path,
            ]);
            //登録完了後にリダイレクト
            return redirect()->route('products.registration');
        } catch (\Exception $e) {
            return redirect()->route('products.registration')->with('error', 'エラーが発生しました。');
        }
    }
}
