@extends('layouts.app')

@section('content')
<h2>商品情報詳細画面</h2>
<table class = "table">
  <tbody>
    <tr>
      <th>ID</th>
      <td>{{$product->id}}</td>
    </tr>
    <tr>
      <th>商品画像</th>
      <td>{{$product->img_path}}</td>
    </tr>
    <tr>
      <th>商品名</th>
      <td>{{$product->product_name}}</td>
    </tr>
    <tr>
      <th>メーカー</th>
      <td>{{$company->company_name}}</td>
    </tr>
    <tr>
      <th>価格</th>
      <td>{{$product->price}}</td>
    </tr>
    <tr>
      <th>在庫数</th>
      <td>{{$product->stock}}</td>
    </tr>
    <tr>
      <th>コメント</th>
      <td>{{$product->comment}}</td>
    </tr>
    <a href = "{{ route('products.edit', ['id' => $product->id])}}" class = "btn btn-primary">編集</a>
    <a href = "{{ route('products.index')}}" class = "btn btn-secondary">戻る</a>
  </tbody>
</table>

@endsection
