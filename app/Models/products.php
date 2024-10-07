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

    protected $fillable = ['company_id','product_name','price','stock','comment','img_path']; //保存したいカラム名が複数の場合
}