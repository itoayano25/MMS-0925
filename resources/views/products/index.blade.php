@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">商品情報一覧</h1>

        <a href="{{ route('products.create')}}" class="btn btn-primary mb-3">商品新規登録</a>

        {{-- 検索のフォームを書く、テキスト検索、セレクトボタン検索、検索ボタン --}}

        <div class="search mt-5">
            <h2>検索条件で絞り込み</h2>

            <form action="{{ route('products.index') }}" method="GET" class="row g-3 form_search">
                @csrf
                {{-- 商品名で検索 --}}
                <div class="col-sm-12">
                    <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}">
                </div>

                {{-- 会社名セレクト検索 --}}
                <div class="col-sm-12">
                    <select class="form-select" name="company_name" value="{{ request('company_name') }}">
                        <option value="">未選択</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>    
                </div>

                {{-- STEP８の非同期の価格下～上限検索 --}}
                <div class="col-sm-6">
                    <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
                </div>
                <div class="col-sm-6">
                    <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
                </div>

                {{-- STEP８の非同期の在庫下～上限検索 --}}
                <div class="col-sm-6">
                    <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
                </div>
                <div class="col-sm-6">
                    <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
                </div>

                {{-- 検索ボタン --}}
                <div class="col-sm-12">
                    {{--　type=inputをボタンに変更し、画面遷移を防ぐつもりが反応しなくなった --}}
                    <button class="btn btn-success btn-search" type="submit">検索</button>
                </div>
            </form>

    
        </div>

        <div id="products_table"  class="products mt-5">
            <h2>商品情報</h2>
            <table class="table table-striped table_sort" id="tablesorter">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品名</th>
                        <th>メーカー</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>コメント</th>
                        <th>商品画像</th>
                        <th>編集</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id}}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->company->company_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->comment }}</td>
                            <td><img src="{{ asset($product->img_path)}}" alt="商品画像" width="100"></td>
                            <td>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
                                {{-- STEP7の削除ボタン --}}
                                {{-- <form onsubmit="return confirm('本当に削除しますか？')" method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline"> --}}
                                    {{-- @csrf --}}
                                    {{-- @method('DELETE') --}}
                                    {{-- <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button> --}}
                                {{-- </form> --}}

                                {{-- STEP8の削除ボタン --}}
                                    <form class="d-inline">
                                        <input data-product_id="{{$product->id}}" type="submit" class="btn btn-danger btn-sm mx-1 delete-btn" value="削除">
                                    </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- 非同期処理のjs --}}
<script src="{{asset('js/hidouki.js')}}"></script>

@endsection('content')
