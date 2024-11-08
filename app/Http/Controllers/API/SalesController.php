<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから商品IDと数量を取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // デフォルト数量を1とする
            // 商品の在庫を確認
            $product = Products::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            //モデルのpurchaseメソッド実行
            $result = $product->purchase($quantity);
            if ($result['success']) {
                return response()->json(['message' => $result['message']], 200);
            } else {
                return response()->json(['error' => $result['message'], 'details' => $result['error']], 500);
            }
    }
}