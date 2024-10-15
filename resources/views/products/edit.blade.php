@extends('layouts.app')

@section('content')
<h2>商品情報編集画面</h2>
    <table class = "table">
<form action = "{{ route('products.update', ['id' => $product->id])}}" method = "post" enctype="multipart/form-data">
@csrf
        <tbody>
            <tr>
                <th>ID</th>
                <td>
                    {{$product->id}}
                    <input type="hidden" name = "id" value = "{{$product->id}}"></input>
                </td>
            </tr>
            <tr>
                <th>商品名<span style=”color:red;”>*</span></th>
                <td>
                    <input name = "product_name" value = "{{$product->product_name}}"></input>
                </td>
            </tr>
            <tr>
                <th>メーカー名<span style=”color:red;”>*</span></th>
                <td> 
                    <select name = "company_id">
                        <option value = ""></option>
                        @foreach($companies as $company)
                            <option value = "{{$company->id}}" @if($company->id===$selected_company->id)selected @endif>{{$company->company_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>価格<span style=”color:red;”>*</span></th>
                <td>
                    <input name = "price" type = "number" min = "0" value = "{{$product->price}}"></input>
                </td>
            </tr>
            <tr>
                <th>在庫数<span style=”color:red;”>*</span></th>
                <td>
                    <input name = "stock" type = "number" min = "0" value = "{{$product->stock}}"></input>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>
                    <textarea name = "comment" type = "text">{{$product->comment}}</textarea>
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
                    <button type="submit" class="btn btn-warning">更新</button>
                    <a href = "{{ route('products.detail', ['id' => $product->id])}}" class = "btn btn-info">戻る</a>
                </td>
            </tr>
        </tbody>
        </form>
    </table>
@endsection
