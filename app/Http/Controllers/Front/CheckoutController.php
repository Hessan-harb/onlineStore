<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\CreateOrderNotification;
use App\Notifications\OrderCreatedNotification;
use App\Repo\Cart\CartRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepo $cart){

        if($cart->get()->count() ==0){
            return redirect()->route('home');
        }

        return view('front.checkout',[
            'cart' => $cart,
            // 'countries'=>['egypt','usa','canada','england','saudi','uke'],
        ]);
    }

    public function store(CartRepo $cart,Request $request){

        $request->validate([
            //'addr.billing.first_name' =>'required', to validate in array validation
        ]);

        $items=$cart->get()->groupBy('product.store_id');

        DB::beginTransaction();
        try{
            foreach($items as $store_id =>$cart_items){

                $order=Order::create([
                    'store_id'=>$store_id,
                    'user_id'=>Auth::id(),
                    'payment_method'=>'cod',
                    ]);

                    foreach($cart_items as $item){
                        OrderItem::create([
                            'order_id'=>$order->id,
                            'product_id'=>$item->product_id,
                            'product_name'=>$item->product->name,
                            'price'=>$item->product->price,
                            'quantity'=>$item->quantity,
                        ]);
                    }
                    $user=Auth::user();

                    foreach($request->post('addr') as $type=>$address){
                        $address['type'] = $type;
                        $order->addresses()->create($address);
                    }
            } 
            $user=User::where('store_id',$order->store_id)->first();


           // $cart->empty();

            DB::commit();
            
            if($user){
                Notification::send($user,new CreateOrderNotification($order));
            }
            
            event(new OrderCreated($order));

        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('home');

        //return redirect()->route('myfatoorah.index',$order->id);
  
    }
}
