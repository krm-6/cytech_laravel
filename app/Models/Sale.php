<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    protected $table = 'sales';
    protected $dates =  ['id', 'product_id', 'created_at', 'updated_at'];
    protected $fillable = ['id', 'product_id', 'created_at', 'updated_at'];

    public function purchase($quantity)
    {try {
        // トランザクション開始
        DB::beginTransaction();
        // 商品の在庫を確認

        if ($this->stock < $quantity) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        // 購入処理: sales テーブルに追加
        Sale::create([
            'product_id' => $this->Id,
            'quantity' => $quantity,
            'price' => $this->price * $quantity,
        ]);

        // 在庫数を減算
        $this->stock -= $quantity;
        $this->save();

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
