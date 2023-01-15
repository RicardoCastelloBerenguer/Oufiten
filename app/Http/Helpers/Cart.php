<?php

namespace App\Http\Helpers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;

class Cart
{
    public static function getCartItemsCount():int{
        $request = \request();
        $user= $request->user();
        if($user){
            return CartItem::where('user_id',$user->id)->sum('quantity');
        }else{
            $cartItems = self::getCookiecartItems();

            return array_reduce(
                $cartItems,
                fn($carry,$item) => $carry + $item['quantity'],0
            );
        }
    }

    public static function getCartItems(){
        $request = \request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );
        } else {
            return self::getCookieCartItems();
        }
    }

    public static function getCookiecartItems(){
        $request = \request();
        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    public static function getCountFromItems($cartItems){
        return array_reduce(
          $cartItems,
          fn($carry,$item) => $carry + $item['quantity'],0
        );
    }

    public static function moveCartItemsIntoDb(){
        $request = \request();
        $user= $request->user();
        $cartItems = self::getCookiecartItems();
        $dbItems = CartItem::where(['user_id' => $user->id])->get()->keyBy('product_id');
        $newCartItems = [];
        foreach ($cartItems as $cartItem){
            if(!isset($dbItems[$cartItem['product_id']])){
                $newCartItems[]=[
                    'user_id' => $request->user()->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            }
        }
        if(!empty($newCartItems)){
            CartItem::insert($newCartItems);
        }
    }
}
