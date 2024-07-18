<?php 
 namespace App\Repo\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Str;

 class CartModelRepo implements CartRepo
 {
    protected $items;

    public function __construct(){

        $this->items = collect([]);
    }

    public function get() : Collection {

        if(!$this->items->count()){
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
    }

    public function add(Product $product,$quantity=1){

        $item=Cart::where('product_id','=',$product->id)
            ->first();
        
        if(!$item){
           $cart= Cart::create([
                'user_id'=>Auth::user()->id,
                'product_id'=>$product->id,
                'quantity'=>$quantity,
            ]);
            
            $this->get()->push($cart);
            return $cart;
        }
        return $item->increment('quantity',$quantity);

    }

    public function update($id,$quantity){
        
        Cart::where('id','=',$id)
            ->update([
                'quantity'=>$quantity,
            ]);
    }

    public function delete($id){

        Cart::where('id','=',$id)
            ->delete();
    }

    public function empty(){

        Cart::query()->delete();
    }

    public function total(): float {
        return $this->get()->sum(function ($item) {
            if ($item->product) {
                return $item->quantity * $item->product->price;
            } else {
                return 0; 
            }
        });
    }

    // public function total() : float {

    //    return $this->get()->sum(function($item){

    //         return $item->quantity * $item->product->price;
    //     });

    //     // return (float) Cart::join('products','products.id','=','carts.product_id')
    //     //     ->selectRaw('SUM(products.price * carts.quantity) as total')
    //     //     ->value('total');
    // }

   
 }