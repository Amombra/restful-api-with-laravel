<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return ProductResource::collection(Product::paginate(20));
    }

    public function show(Product $product){
        return  ProductCollection::collection($product);
    }
}
