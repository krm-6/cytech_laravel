@extends('layouts.app')

@push('style')
<link rel = "stylesheet" href="{{ asset('/css/edit.css') }}">
@endpush

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
                <th>商品名<span class = "kome">*</span></th>
                <td>
                    <input name = "product_name" value = "{{old($product->product_name)}}"></input>
                </td>
            </tr>
            <tr>
                <th>メーカー名<span class = "kome">*</span></th>
                <td>
                    <select name = "company_id">
                        <option value = ""></option>
                        @php
                            // 選択されたidを変数に入れる。選択されたメーカー名をintval関数で数値化し、それをold関数で保持する。
                            $selected_company_id = old('company_id') ? intval(old('company_id')) : $selected_company->id;
                        @endphp
                        @foreach($companies as $company)
                            <option value = "{{$company->id}}" {{$company->id===$selected_company_id ? 'selected': ''}}>{{$company->company_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>価格<span class = "kome">*</span></th>
                <td>
                    <input name = "price" type = "number" min = "0" value = "{{old($product->price)}}"></input>
                </td>
            </tr>
            <tr>
                <th>在庫数<span class = "kome">*</span></th>
                <td>
                    <input name = "stock" type = "number" min = "0" value = "{{old($product->stock)}}"></input>
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>
                    <textarea name = "comment" type = "text">{{old('comment')}}</textarea>
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
