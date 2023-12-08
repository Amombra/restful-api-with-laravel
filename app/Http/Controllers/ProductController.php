<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Facade\FlareClient\Http\Response;
use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

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

        $this->ProductUserCheck($product);
        $request['detail'] = $request->detail;
        unset($request['detail']);
        $product->update($request->all());
        return  response([
            'data' => new ProductResource(($product))
        ], 201);
    }

    public function destroy(Product $product){
        return $product->delete();
        return  response(null, 201);
    }

    public function ProductUserCheck($product){
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }
}
