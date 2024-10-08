@extends('layouts.app')

@section('content')
<h2>商品新規登録画面</h2>
<table class = "table">
    <form action = "{{ route('products.register')}}" method = "post">
        @csrf
        <tbody>
            <tr>
                <th>ID*</th>
                <td>
                    <input name = "id"></input>
                </td>
            </tr>
            <tr>
                <th>商品名*</th>
                <td>
                    <input name = "product_name"></input>
                </td>
            </tr>
            <tr>
                <th>メーカー名*</th>
                <td>
                    <input name = "company_id"></input>
                </td>
            </tr>
            <tr>
                <th>価格*</th>
                <td>
                    <input name = "price"></input>
                </td>
            </tr>
            <tr>
                <th>在庫数*</th>
                <td>
                    <input name = "stock"></input>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>
                    <textarea name = "comment"></textarea>
                </td>
            </tr>
            <tr>
                <th>商品画像</th>
                <td>
                    <input name = "img_path"></input>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" class="btn btn-info">新規登録</button>
                    <button class="btn btn-info" onclick="{{ route('products.index') }}">戻る</button>
                </td>
            </tr>
        </tbody>
    </form>
</table>
@endsection
