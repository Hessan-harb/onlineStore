<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders=Order::paginate(10);
        return view('dashboard.order.index',compact('orders'));
    }

    public function destroy($id){

        $order=Order::findOrFail($id);
        $order->delete();
        //$orders->delete();
        return redirect()->route('orders.index')->with('success','order deleted successfully');
    }
}
