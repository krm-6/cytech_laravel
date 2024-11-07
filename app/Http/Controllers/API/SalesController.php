<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから商品IDと数量を取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // デフォルト数量を1とする


        try {
            // トランザクション開始
            DB::beginTransaction();
            // 商品の在庫を確認
            $product = Products::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            if ($product->stock < $quantity) {
                return response()->json(['error' => 'Insufficient stock'], 400);
            }

            // 購入処理: sales テーブルに追加
            Sale::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price * $quantity,
            ]);

            // 在庫数を減算
            $product->stock -= $quantity;
            $product->save();

            // トランザクションをコミット
            DB::commit();

            return response()->json(['message' => 'Purchase successful'], 200);

        } catch (\Exception $e) {
            // エラーが発生した場合、ロールバック
            DB::rollBack();
            return response()->json(['error' => 'Purchase failed', 'message' => $e->getMessage()], 500);
        }
    }
}