@extends('layouts.app')

@push('style')
<link rel = "stylesheet" href="{{ asset('/css/index.css') }}">
@endpush

@push('scriptLib')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js" integrity="sha512-2rtCjYosDLad+w5206/5H70qYKuNZmBqezdneblfAlaq1w9JVJx0zyLPee97nG7iYrwqfcf455QTLdE68JFgww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
@endpush

@section('content')
<h2>商品一覧画面</h2>

<!-- 検索フォーム -->
<div  id = "search">
    <div class = "input-group">
            <input id = "productName" type = "text" class = "form-control" placeholder = "検索キーワード" value="{{request('keyword')}}"></input>
            <select id = "companyId" class="form-control">
                <option value = "">メーカー名</option>
                @foreach($companies as $company)
                    <option value = "{{$company->id}}" {{$company->id===intval(request('company_id')) ? 'selected': ''}}>{{$company->company_name}}</option>
                @endforeach
            </select>
            <!-- 価格入力 -->
            <input type="number" id="priceMin" placeholder="価格（下限）">
            <input type="number" id="priceMax" placeholder="価格（上限）">
            <!-- 在庫数入力 -->
            <input type="number" id="stockMin" placeholder="在庫数（下限）">
            <input type="number" id="stockMax" placeholder="在庫数（上限）">

            <button id = "searchBtn" class = "btn">
                検索
            </button>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
    </div>
</div>




<table id = "productTable" class = "table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>メーカー名</th>
      <th>
      <a href = "{{ route('products.registration') }}">
        <button type="button" class="btn btn-warning">新規登録</button>
        </a>
    </th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

@endsection
@section('script')
    <script>
        //ページが読み込まれたら実行
        $(document).ready(function() {

            const getList = function() {
                //検索ボタンがクリックされた時の処理
                //検索ボックスの値を取得して変数に代入
                let product_name = $('#productName').val();
                let company_id = $('#companyId').val();
                let price_min = $('#priceMin').val();
                let price_max = $('#priceMax').val();
                let stock_min = $('#stockMin').val();
                let stock_max = $('#stockMax').val();
                //Ajaxリクエストを送信
                $.ajax({
                    //Larabelのルートヘルパーを使う
                    url: '{{ route('products.search') }}',
                    //HTTPメソッドのGETリクエスト
                    method: 'GET',
                    //リクエストのデータとして変数を送信。｛｝内の左がキー名。
                    data: { 
                        product_name: product_name,
                        company_id: company_id,
                        price_min: price_min,
                        price_max: price_max,
                        stock_min: stock_min,
                        stock_max: stock_max
                    },
                    //リクエストが成功した時の処理
                    success: function (data) {
                        //結果を格納するHTML文字列を初期化
                        $('#productTable tbody').html('');
                        //dataはサーバーから帰ってきたJSONデータ。各productに対してHTMLを作成。
                        let productDetailBaseUrl = "{{ route('products.detail', ['id' => ':id']) }}";
                        let productDestroyBaseUrl = "{{ route('products.destroy', ['id' => ':id']) }}";
                        data.forEach(function (product) {
                            let productDetailUrl = productDetailBaseUrl.replace(':id', product.id);
                            let productDestroyUrl = productDestroyBaseUrl.replace(':id', product.id);
                            //検索結果を表示する場所の要素に結果のHTMLを挿入して表示
                            $('#productTable tbody').append(`
                                <tr class = "ProductRow">
                                    <td>${product.id}</td>
                                    <td><img src="${ '{{asset("storage/Image")}}' + '/' + product.img_path }" class = "ProductImage"></td>
                                    <td>${product.product_name}</td>
                                    <td>¥${product.price}</td>
                                    <td>${product.stock}</td>
                                    <td>${product.company_name}</td>
                                    <td>
                                        <a href="${productDetailUrl}" class="btn btn-info">詳細</a>
                                        <button class = "btn btn-danger BtnDestroy" data-id = "${product.id}">削除</button>
                                    </td>
                                </tr>
                            `);
                        });
                        
                        // 現在のtablesorterを破棄して再適用
                        $("#productTable").trigger("destroy").tablesorter();
                    },
                    error: function (error) {
                    //リクエストが失敗した時のエラーをコンソールに表示
                        console.error("Error:", error);
                    }
                });
            }



            //クリックイベントを設定。onclickを使うと後から追加された要素にもイベントを適用できるようになる。
            //tablesorter実装
            $('#productTable').tablesorter({
                headers: {
                    1: { sorter: false }, // 2列目をソートしない
                    6: { sorter: false }  // 7列目をソートしない
                }
            });
            // 初期表示時に全件検索
            getList();
            // 検索ボタン押下イベント
            $('#searchBtn').click(function() {
                getList();
            });
            // 削除ボタン押下イベント
            $('#productTable').on('click', '.BtnDestroy',function(e) {
                //eはクリックイベントのイベントオブジェクト。preventDefault();で削除ボタンのデフォルトのクリック動作をキャンセルできる。
                e.preventDefault();
                // thisはクリックされた削除ボタン要素。data-id属性で削除対象のＩＤを取得。
                let self = $(this);
                let productId = self.data('id');
                $.ajax({
                    url: '{{ route('products.destroy') }}',
                    method: 'POST',
                    data: {
                        id: productId
                    },
                    // X-CSRF-TOKEN ヘッダーに csrf_token() を使ってCSRFトークンを設定するとJSで送信するAJAXリクエストが、サーバー側で正当と見なされるようになる。
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function() {
                        self.parents('.ProductRow').remove();
                    },
                    error: function (error) {
                    //リクエストが失敗した時のエラーをコンソールに表示
                        console.error("Error:", error);
                    }
                });
            })
        });
    </script>
@endsection
