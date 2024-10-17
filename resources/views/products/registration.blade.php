@extends('layouts.app')

@push('style')
<link rel = "stylesheet" href="{{ asset('/css/registration.css') }}">
@endpush

@section('content')
<h2>商品新規登録画面</h2>
<table class = "table">
    <form action = "{{ route('products.register')}}" method = "post">
        @csrf
        <tbody>
            <tr>
                <th>商品名<span class = "kome">*</span></th>
                <td>
                    <input name = "product_name" type = "text" value="{{ old('product_name') }}"></input>
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
                        @foreach($companies as $company)
                            <option value = "{{$company->id}}" {{ old('company_id') == $company->id ? 'selected' : ''}}>{{$company->company_name}} </option>
                        @endforeach
                    </select>
                    @if ($errors->has('company_id'))
                        <div class="alert alert-danger">
                            {{ $errors->first('company_id') }}
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <th>価格<span class = "kome">*</span></th>
                <td>
                    <input name = "price" type = "number" min = "0" value="{{ old('price') }}"></input>
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
                    <input name = "stock" type = "number" min = "0" value="{{ old('stock') }}"></input>
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
                    <textarea name = "comment" type = "text">{{ old('comment') }}</textarea>
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
                    <button type="submit" class="btn btn-warning">新規登録</button>
                    <a href = "{{ route('products.index')}}" class = "btn btn-info">戻る</a>
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
