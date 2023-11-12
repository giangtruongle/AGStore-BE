<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCartController extends Controller
{
    public function addProductToCart(Request $request){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $name = $request->name;
            $quantity = $request->quantity;
            $price = $request->price;
            $size = $request->size;
            $image_url = $request->image_product;

            $productCheck = Product::where('id', $product_id)->first();
            if($productCheck){
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id)->where('size',$size)->exists())
                {
                    return response()->json([
                    'status'=> 409,
                    'message'=>$productCheck->name.'Already Added to Cart'
                ]);
                }else{
                    $item_order = new Cart;
                    $item_order->user_id = $user_id;
                    $item_order->product_id = $product_id;
                    $item_order->name = $name;
                    $item_order->price = $price;
                    $item_order->size = $size;
                    $item_order->quantity = $quantity;
                    $item_order->image_url = $image_url;
                    $item_order->save();

                    return response()->json([
                    'status'=> 201,
                    'message'=>'Added to Cart'
                ]);
                }

            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found'
                ]);
            }

        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to Add to cart'
            ]);
        }
    }

    public function showListCart(){
        
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartItems = Cart::where('user_id',$user_id)->get();
            return response()->json([
                'status'=>200,
                'cartItems'=>$cartItems,
            ]);

        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to View List Shopping Cart'
            ]);
        }
    }

    public function updateQuantity($cart_id, $scope){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();
            if($scope === 'insc'){
                $cartItem->quantity += 1;
            }else if($scope === 'desc'){
                $cartItem->quantity -= 1;
            }
            $cartItem->update();

            return response()->json([
                'status'=>200,
                'message'=>'Quantity Updated'
            ]);
           
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to Continute'
            ]);
        }
    }

    public function deleteCartItem($cart_id){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cartItem = Cart::where('id',$cart_id)->where('user_id',$user_id)->first();

            if($cartItem){
                $cartItem->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>"Cart Item Removed Successfully"
                ]);

            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>"Cart Item not found"
                ]);
            }
        }else{
            return response()->json([
                'status'=>401,
                'message'=>"Login to continute"

            ]);
        }
    }
}
