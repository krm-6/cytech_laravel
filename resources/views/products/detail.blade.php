@extends('layouts.app')

@push('style')
<link rel = "stylesheet" href="{{ asset('/css/detail.css') }}">
@endpush

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
      <td><img src="{{ asset('storage/Image/' . $product->img_path) }}" class = "ProductImage"></td>
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
      <td>¥{{$product->price}}</td>
    </tr>
    <tr>
      <th>在庫数</th>
      <td>{{$product->stock}}</td>
    </tr>
    <tr>
      <th>コメント</th>
      <td>{{$product->comment}}</td>
    </tr>
    <tr>
        <td colspan = "2">
            <a href = "{{ route('products.edit', ['id' => $product->id])}}" class = "btn btn-warning">編集</a>
            <a href = "{{ route('products.index')}}" class = "btn btn-info">戻る</a>
        </td>
    </tr>
  </tbody>
</table>

@endsection

