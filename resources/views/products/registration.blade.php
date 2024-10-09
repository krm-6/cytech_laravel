@extends('layouts.app')

@section('content')
<h2>商品新規登録画面</h2>
<table class = "table">
    <form action = "{{ route('products.register')}}" method = "post">
        @csrf
        <tbody>
            <tr>
                <th>商品名*</th>
                <td>
                    <input name = "product_name" type = "text"></input>
                </td>
            </tr>
            <tr>
                <th>メーカー名*</th>
                <td>
                    <select name = "company_id">
                        <option value = ""></option>
                        @foreach($companies as $company)
                            <option value = "{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>価格*</th>
                <td>
                    <input name = "price" type = "number" min = "0"></input>
                </td>
            </tr>
            <tr>
                <th>在庫数*</th>
                <td>
                    <input name = "stock" type = "number" min = "0"></input>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>
                    <textarea name = "comment" type = "text"></textarea>
                </td>
            </tr>
            <tr>
                <th>商品画像</th>
                <td>
                    <input type="file" name="img_path"/>
                </td>
            </tr>
            <tr>
                <td colspan = "2">
                    <button type="submit" class="btn btn-warning">新規登録</button>
                    <a href = "{{ route('products.index')}}" class = "btn btn-info">戻る</a>
                </td>
            </tr>
        </tbody>
    </form>
</table>
@endsection
