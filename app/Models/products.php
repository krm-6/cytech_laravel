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
    
    public function updateProduct(array $validated_data, $img_path = null) {
        //array_merge 関数で$validated_data 配列に img_path の要素を追加。
        //フォームで入力されたデータに画像パスが統合、img_path も含まれる更新データとして準備。
        //モデルインスタンス(モデルインスタンスとは、特定のデータベースレコード（行）を表すオブジェクト)自身の update メソッドを呼び出し、更新。
        //$this は現在のモデルインスタンス。
        return $this-> update(array_merge($validated_data, ['img_path' => $img_path]));
    }

    public static function deleteProduct(int $id) {
    //static：このメソッドが「静的メソッド」であることを示す。静的メソッドは、インスタンスを作成せずにクラス名から直接呼び出せる。
        $product = self::find($id);
        //現在のクラス（Productsモデルクラス）で指定した id に基づいてデータベースからレコードを検索。見つかった場合は、そのレコードをモデルインスタンスとして返す。
        if($product) {
        //指定したidに対応するレコードがあるか確認。見つからない場合はnullとなり、削除はスキップ。
            return $product->delete();
        }
        return false;
        //レコードがない場合falseを返す。
    }
    
    public static function searchProducts(array $where)
    {
        return self::where($where)
        //指定された where 条件を使用してデータを絞り込み。この条件は配列形式で渡され、条件に合致するレコードを取得するフィルタリングする。
            //会社名を表示するためにテーブルを結合。
            ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
            //products テーブルの全カラムと、companies テーブルの company_name カラムだけを選択して取得することで、会社名も一緒に検索結果として返される。
            ->select('products.*', 'companies.company_name')
            //条件を配列形式で渡し（$where）、SQLのWHERE条件を作成
            ->where($where)
            ->get();
        }
}