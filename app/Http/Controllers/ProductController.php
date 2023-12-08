<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class ProductController extends Controller

{

    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show');
    }

    public function index(){
        
        return  ProductResource::collection(Product::paginate(20));  
    }

    public function show(Product $product){
        return  ProductResource::collection($product);
    }

    public function store(ProductRequest $request){
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();
        return response([
            'data' => new ProductResource(($product))
        ], 201);
    }

    public function update(Request $request, Product $product){
        $request['detail'] = $request->detail;
        unset($request['detail']);
        $product->update($request->all());
        return  response([
            'data' => new ProductResource(($product))
        ], 201);
    }
}
