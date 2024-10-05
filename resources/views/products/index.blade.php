@extends('layouts.app')

@section('content')
<h2>商品一覧画面</h2>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>
        <button type="button" class="btn btn-warning">新規登録</button>
    </th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->img_path}}</td>
            <td>{{$product->product_name}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->stock}}</td>
            <td>
                <button type="button" class="btn btn-info">詳細</button>
                <button type="button" class="btn btn-danger">削除</button>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>

@endsection