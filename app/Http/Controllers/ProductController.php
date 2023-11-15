<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->company = new Company();
        $this->product = new Product();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product,Request $request)
    {
        $query = Product::query();
        // 商品名部分一致検索
        if($search = $request->search){
            $query->where('product_name', 'LIKE', "%{$search}%");
        }
        // company_idセレクト検索
        if($company_name = $request->company_name){
            $query->where('company_id', 'LIKE', "$company_name");
        }
        $products = $query->get();
        $companies = $this->company->findCompanies();
        return view('products.index',compact('products','companies'));

        // $products = Product::all();
        // return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // CompanyModelにてメソッドに変更
        $companies = $this->company->findCompanies();
        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // トランザクション追加
    public function store(Request $request)
    {
        DB::transaction(function() use($request){

        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
        ]);

        // ProductModelにて新規登録メソッドに変更
        $product = $this->product->ProductRegister($request);

        if($request->hasFile('img_path')){
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();
        });
        return redirect('products');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // CompanyModelにてメソッドに変更
        $companies = $this->company->findCompanies();
        return view('products.edit',compact('product','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // トランザクション
    public function update(Request $request, Product $product)
    {
        DB::transaction(function() use($request,$product){

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        // 商品情報の更新
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->company_id = $request->company_id;
        
        if($request->hasFile('img_path')){
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            Storage::delete('/storage/' . $filePath);
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();
        });
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // トランザクション
    public function destroy(Request $request, Product $product)
    {
        // DB::transaction(function() use($product){
            // $product->delete();
        // });
            // return redirect('products');

            $product = Product::findOrFail($request->id);
            $product->delete();
            
    }
}
