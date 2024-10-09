@extends('layouts.app')

@section('content')
<h2>商品一覧画面</h2>

<!-- 検索フォーム -->
<form action = "{{ route('products.search') }}" method = "GET">
    <div class = "input-group">
        <input name="keyword" type = "text" class = "form-control input-group-prepend" placeholder = "検索キーワード"></input>
        <select name = "company_id">
                        <option value = ""></option>
                        @foreach($companies as $company)
                            <option value = "{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
        </select>
        <span class = "input-group-btn input-group-append">
            <submit type = "submit" id = "btn-search" class = "btn" onclick = "clickSearch()">
                検索
            </submit>
        </span>
    </div>
</form>




<table class = "table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>
      <a href = "{{ route('products.registration') }}">
        <button type="button" class="btn btn-warning">新規登録</button>
        </a>
    </th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->img_path}}</td>
            <td>{{$product->product_name}}</td>
            <td>¥{{$product->price}}</td>
            <td>{{$product->stock}}</td>
            <td>
                <a href = "{{ route('products.detail', ['id' => $product->id]) }}" class = "btn btn-info">詳細</a>
                <form action = "{{ route('products.destroy', ['id'=> $product->id]) }}" method = "POST" class = "d-inline">
                    @csrf 
                    <button type = "submit" class = "btn btn-danger">削除</button>
                </form>
            </td>

        </tr>
    @endforeach
  </tbody>
</table>

@endsection
