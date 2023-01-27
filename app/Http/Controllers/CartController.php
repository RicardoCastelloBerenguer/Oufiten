<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(Request $request){
        /** @var \App\Models\User $user */
        $user = $request->user();

        $disabled=false;

        if($user){
            $customerShippingAddress = $user->customer->shippingAddress;
            $customerBillingAddress = $user->customer->billingAddress;

            if(is_null($customerShippingAddress) || is_null($customerBillingAddress)){
                $disabled = true;
            }
        }

        $cartItems = Cart::getCartItems();
        $idsItems= Arr::pluck($cartItems,'product_id');
        $products = Product::query()->whereIn('id',$idsItems)->get();
        $cartItems = Arr::keyBy($cartItems,'product_id');
        $totalItemsPrice = 0;
        foreach ($products as $product){
            $totalItemsPrice += $product->price * $cartItems[$product->id]['quantity'];
        }

        return view('cart.index', compact('cartItems' , 'products', 'totalItemsPrice','disabled'));
    }

    public function add(Request $request,Product $product){
        $quantity = $request->post('quantity',1);
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['user_id' => $user->id ,'product_id'=> $product->id])->first();

            if($cartItem){
                $cartItem->quantity += $quantity;
                $cartItem->update();
            }else{
                $cartItem=[
                    'user_id'=> $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ];

                CartItem::create($cartItem);
            }
            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        }
        else{
            $cartItems = json_decode($request->cookie('cart_items', '[]'),true);
            $found = false;


            foreach ($cartItems as &$item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] += $quantity;
                    $found=true;
                    break;
                }
            }
            if(!$found){
                $cartItems[] = [
                  'user_id' => null,
                  'product_id' => $product->id,
                  'quantity' => $quantity,
                  'price' => $product->price,
                ];
            }
            //ERROR
            Cookie::queue('cart_items',json_encode($cartItems),60*24*15);


            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
    public function remove(Request $request,Product $product){

        $user=$request->user();
        if($user){
            $cartItem = CartItem::query()->where(['user_id' => $user->id , 'product_id' => $product->id])->first();

            if($cartItem){
                $cartItem->delete();
            }
            return response(['count' => Cart::getCartItemsCount()]);
        }else{
            $cartItems = json_decode($request->cookie('cart_items','[]'),true);
            foreach ($cartItems as $i => $item){
                if($item['product_id'] == $product->id){
                    array_splice($cartItems,$i,1);
                    break;
                }
            }
            Cookie::queue('cart_items',json_encode($cartItems),60*24*15);

            return response(['count' => Cart::getCartItemsCount()]);
        }
    }
    public function updateQuantity(Request $request,Product $product){
        $quantity = (int)$request->post('quantity');
        $user = $request->user();
        if($user){
            CartItem::where(['product_id' => $product->id , 'user_id' => $user->id])->update(['quantity' => $quantity]);

            return response(['count' => Cart::getCartItemsCount()]);
        }
        else{
            $cartItems = json_decode($request->cookie('cart_items','[]'),true);
            $lastItem = 2;
            foreach ($cartItems as &$item) {
                if($item['product_id'] == $product->id){
                    $item['quantity'] = $quantity;
                    $lastItem=$item;
                    break;
                }
            }
            Cookie::queue('cart_items',json_encode($cartItems),60*24*15);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
