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
        $model = new Products();
        $products = $model->getLists([]);
        $companies = companies::all();
        return view('products.index', compact('products', 'companies'));
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
            $id = $request->input('id');
            // IDに基づいて投稿を取得
            $product = Products::findOrFail($id);
            $validatedData = $request->validated();
            try {
                
                if ($request->img_path) {
                    $img_path = basename($request->file('img_path')->store('public/Image'));
                } else {
                    $img_path = null;
                }

                $product->update(
                    [
                        'product_name' => $validatedData['product_name'],
                        'company_id' => $validatedData['company_id'],
                        'price' => $validatedData['price'],
                        'stock' => $validatedData['stock'],
                        'comment' => $validatedData['comment'],
                        'img_path' => $img_path,
                    ]
                );
                // 投稿データをedit.blade.phpに渡す
                return redirect()->route('products.edit', compact('id'));
            } catch (\Exception $e) {
                return redirect()->route('products.edit', ['id' => $product->id])->with('error', 'エラーが発生しました。');
            }
    }
        /**
     * 削除処理
     */
    public function destroy (Request $request)
    {
        // Productsテーブルから指定のIDのレコード1件を取得
        $product = Products::find($request->input('id'));
        // レコードを削除
        $product->delete();
        // 削除したら一覧画面にリダイレクト
        return response() -> json();
    }
    //キーワード検索
    public function search(Request $request)
    {
        // 検索キーワードを取得
        $product_name = $request->input('product_name');
        $company_id = $request->input('company_id');
        $model = new Products();
        $where = [];

        if ($product_name || $company_id) {
            if($product_name){
                array_push($where, ['product_name', 'like', "%{$product_name}%"]);
            }
            if($company_id){
                array_push($where, ['company_id', '=', $company_id]);
            }
        } 
        $products = $model->getLists($where);
        // ビューに検索結果を渡す
        $companies = companies::all();
        return response() -> json($products);
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
    {
        $validatedData = $request->validated();
        try {
             
            if ($request->img_path) {
                $img_path = basename($request->file('img_path')->store('public/Image'));
            } else {
                $img_path = null;
            }
            // 作成処理
            Products::create([
                'product_name' => $validatedData['product_name'],
                'company_id' => $validatedData['company_id'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'comment' => $validatedData['comment'],
                'img_path' => $img_path,
            ]);
            return redirect()->route('products.registration');
        } catch (\Exception $e) {
            return redirect()->route('products.registration')->with('error', 'エラーが発生しました。');
        }
    }

    public function registSubmit(ProductsRequest $request) {
        DB::beginTransaction();

        try {
            $model = new Products();
            $model -> registProducts($request);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            return back();
        }
        return redirect(route('regist'));
    }
}
