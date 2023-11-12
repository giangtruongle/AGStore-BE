<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderPlace;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request){
        if(auth('sanctum')->check()){

            $validator = Validator::make($request->all(),[
                'user_name' => 'required',
                'address' => 'required|min:10|max:512',
                'email' => 'required',
                'phone' => 'required|numeric|min:8',
                'payment_method' => 'required',
                'subtotal' => 'required',
                'total' => 'required',
                'note'=>'nullable',

            ]);
            if($validator->fails()){
                return response()->json([
                    'status'=>422,
                    'errors'=>$validator->messages()
                ]);

            }else{
                $user_id = auth('sanctum')->user()->id;
                $order = new Orders;
                $order->user_id = $user_id;
                $order->user_name = $request->user_name;
                $order->address = $request->address;
                $order->email = $request->email;
                $order->phone = $request->phone;
                $order->payment_method = $request->payment_method;
                $order->subtotal = $request->subtotal;
                $order->total = $request->total;
                $order->note = $request->note;
                $order->status = Orders::STATUS_PENDING;
                $order->save();

                $cart = Cart::where('user_id',$user_id)->get();

                $order_items = [];
                foreach($cart as $item){
                    $order_items[] = [
                        'product_id'=>$item->product_id,
                        'quantity'=>$item->quantity,
                        'price'=>$item->product->price,
                        'name'=>$item->product->name,
                        'size'=>$item->product->size
                    ];

                    $item->product->update([
                        'quantity'=>$item->product->quantity - $item->quantity
                    ]);

                }
                $order->order_items()->createMany($order_items);
                Cart::destroy($cart);

                return response()->json([
                    'status'=>200,
                    'message'=>'Order Place Successfully'
                ]);
            }
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login to continute'
            ]);
        }
    }
}
