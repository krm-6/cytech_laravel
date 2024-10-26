<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'created_at',
        'updated_at'
    ];//保存したいカラム名が複数の場合

    // モデルに関連付けるテーブル
    protected $products = 'products';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 一覧表示用リスト取得（companiesテーブルと結合）
    public function getLists($where) {
        $products = $this
        ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->where($where)
        ->get();
        return $products;
    }

    // company_idに紐づくcompaniesを取得
    public function company() {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    
    

}
