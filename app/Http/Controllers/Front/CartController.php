<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repo\Cart\CartModelRepo;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected $cart;
    public function __construct(CartModelRepo $cart)
    {
            $this->cart=$cart;
    }

    public function index(){

        return view('front.cart.cart',[
            'cart'=>$this->cart,
        ]);
    }

    public function store(Request $request,CartModelRepo $cart){

        $request->validate([
            'product_id'=>['required','int','exists:products,id'],
            'quantity'=>['nullable','int','min:1'],
        ]);

        $product=Product::findOrFail($request->post('product_id'));
        $cart->add($product,$request->post('quantity'));
    }

    public function update(Request $request ,$id){

        $request->validate([
            'quantity'=>['required','int','min:1'],
        ]);

        $this->cart->update($id,$request->post('quantity'));

        return redirect()->route('cart.index')->with('success','product added successfully');
    }// to video 11.1 checkout

    public function destroy($id){

        $this->cart->delete($id);

        return [
            'message'=>'item deleted successfully',
        ];
    }
}
