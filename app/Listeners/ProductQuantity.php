<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order=$event->order;
        try{
          foreach($order->products as $product){
            $product->decrement('quantity',$product->order_item->quantity);
            // Product::where('id','=',$item->porduct_id)
            //     ->update([
            //         'quantity' => DB::raw("quantity -  {$item->quantity}"),
            //     ]);
            }   
        }catch(Throwable $e){
            
        }
       
    }
}
