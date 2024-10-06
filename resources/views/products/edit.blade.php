@extends('layouts.app')

@section('content')
<h2>商品情報編集画面</h2>
<table class="table">
  <tbody>
    <tr>
      <th>ID</th>
      <td>{{$product->id}}</td>
    </tr>
    <tr>
      <th>商品名*</th>
      <td>{{$product->product_name}}</td>
    </tr>
    <tr>
      <th>メーカー名*</th>
      <td>{{$company->company_name}}</td>
    </tr>
    <tr>
      <th>価格*</th>
      <td>{{$product->price}}</td>
    </tr>
    <tr>
      <th>在庫数*</th>
      <td>{{$product->stock}}</td>
    </tr>
    <tr>
      <th>コメント</th>
      <td>{{$product->comment}}</td>
    </tr>
    <tr>
      <th>商品画像</th>
      <td>{{$product->img_path}}</td>
    </tr>
    <button type="button" class="btn btn-info" onclick="redirect()->route('products.edit')">更新</button>
    <button type="button" class="btn btn-info" onclick="{{ route('products.detail', ['id' => $product->id]) }}">戻る</button>
  </tbody>
</table>

@endsection