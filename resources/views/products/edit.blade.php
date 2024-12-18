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
                    <input name = "product_name" value = "{{$product->product_name}}"></input>
                    @if ($errors->has('product_name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('product_name') }}
                        </div>
                    @endif
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
                    @php
                        // 選択されたidを変数に入れる。選択されたものをold関数で保持する。
                        $price = old('price') || old('price') === "" ? old('price') : $product->price;
                    @endphp
                    {{-- 上で判定されたもの（$price）を値として代入する。 --}}
                    <input name = "price" type = "number" min = "0" value = "{{$price}}"></input>
                    @if ($errors->has('price'))
                        <div class="alert alert-danger">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <th>在庫数<span class = "kome">*</span></th>
                <td>
                    @php
                        // 選択されたidを変数に入れる。選択されたものをold関数で保持する。
                        $price = old('stock') || old('stock') === "" ? old('stock') : $product->stock;
                    @endphp
                    {{-- 上で判定されたものを値として代入する。 --}}
                    <input name = "stock" type = "number" min = "0" value = "{{($product->stock)}}"></input>
                    @if ($errors->has('stock'))
                        <div class="alert alert-danger">
                            {{ $errors->first('stock') }}
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>
                    @php
                        // 選択されたidを変数に入れる。選択されたものをold関数で保持する。
                        $price = old('comment') || old('comment') === "" ? old('comment') : $product->comment;
                    @endphp
                    {{-- 上で判定されたものを値として代入する。 --}}
                    <textarea name = "comment" type = "text">{{$product->comment}}</textarea>
                    @if ($errors->has('comment'))
                        <div class="alert alert-danger">
                            {{ $errors->first('comment') }}
                        </div>
                    @endif
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
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </td>
            </tr>
        </tbody>
        </form>
    </table>
@endsection
