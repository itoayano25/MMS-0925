<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    public function purchase(Request $request){
        //トランザクション
        DB::transaction(function() use($request){
        // リクエストから商品IDと購入数を取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // DBから対象商品を検索・取得
        $product = Product::find($productId);

        // 商品が存在していない、在庫不足の場合のバリデーション
        if(!$product){
            return response()->json(['message' => '商品が存在しません'],404);
        }
        if($product->stock < $quantity){
            return response()->json(['message' => '商品が在庫不足です',400]);
        }
        // 在庫の減少
        $product->stock -= $quantity;
        $product->save();
        // Saleテーブルに商品IDと購入日時を記録する
        $sale = new Sale([
            'product_id' => $productId,
        ]);
        $sale->save();
        });
        return response()->json(['message' => '購入成功']);
    }
}
