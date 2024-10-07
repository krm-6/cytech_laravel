@extends('layouts.app')

@section('content')
<h2>商品情報編集画面</h2>
    <table class = "table">
<form action = "{{ route('products.update', ['id' => $product->id])}}" method = "post">
@csrf
        <tbody>
            <tr>
            <th>ID</th>
            <td>

                <input name = "id"  value = "{{$product->id}}"></input>
            </td>
            </tr>
            <tr>
            <th>商品名*</th>
            <td>
                <input name = "product_name" value = "{{$product->product_name}}"></input>
            </td>
            </tr>
            <tr>
            <th>メーカー名*</th>
            <td>{{$company->company_name}}</td>
            </tr>
            <tr>
            <th>価格*</th>
            <td>
                <input name = "price" value = "{{$product->price}}"></input>
            </td>
            </tr>
            <tr>
            <th>在庫数*</th>
            <td>
                <input name = "stock" value = "{{$product->stock}}"></input>
            </td>
            </tr>
            <tr>
            <th>コメント</th>
            <td>
                <input name = "comment" value = "{{$product->comment}}"></input>
            </td>
            </tr>
            <tr>
            <th>商品画像</th>
            <td>{{$product->img_path}}</td>
            </tr>
            <tr>
                <td>
                    <button type="submit" class="btn btn-info">更新</button>
                    <button class="btn btn-info" onclick="{{ route('products.detail', ['id' => $product->id]) }}">戻る</button>
                </td>
            </tr>
        </tbody>
        </form>
    </table>
@endsection