<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    public function company() {
        return $this->belongsTo(Companies::class, 'company_id');
    }

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

    
    

}
