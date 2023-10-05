@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">商品情報一覧</h1>

        <a href="{{ route('products.create')}}" class="btn btn-primary mb-3">商品新規登録</a>

        {{-- 検索のフォームを書く　テキスト検索、セレクトボタン検索、検索ボタン --}}

        <div class="search mt-5">
            <h2>検索条件で絞り込み</h2>

            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                @csrf
                {{-- 商品名で検索 --}}
                <div class="col-sm-12 col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}">
                </div>

                {{-- 会社名セレクト検索 --}}
                <div class="col-sm-12 col-md">
                    <select class="form-select" name="company_name" value="{{ request('company_name') }}">
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>    
                </div>

                <div class="col-sm-12 col-md-1">
                    <button class="btn btn-success" type="submit">検索</button>
                </div>
            </form>

    
        </div>

        <div class="products mt-5">
            <h2>商品情報</h2>
            <table class="table table-striped">
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
                                {{-- deleteのアラート --}}
                                <form onsubmit="return confirm('本当に削除しますか？')" method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    
    </div>
@endsection('content')