<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    public function index(){
        $products = Product::query()
        ->where('show_catalogue' , '=' , true)
        ->orderBy('updated_at','desc')->paginate(8);
        return view('product.index',[
           'products' => $products
        ]);
    }
    public function view(){
        return view('profile.view');
    }
    public function show(Product $product){
        return view('product.view',['product' => $product]);
    }
}
