<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private $services;

    public function __construct( $services)
    {
        $this->services = $services;
    }
    public function payOrder(){

        $data= [
            "CustomerName"=>'hussein',
            "CustomerEmail"=>'hussein@gmail.com',
            "InvoiceValue"=>100,
            "Language"=>'en',
            "DisplayCurrencyIso"=>'EGY',
            "CallBackUrl"=>'http://google.com',
            "ErrorUrl"=>'http://youtube.com',
            "NotificationOption"=>'LNK',
        ];

        return $this->services->sendPayment($data);
        
    }
    public function create(Order $order){

        return view('front.payments.create',[
            'order' => $order
        ]);
    }

    public function session(Request $request,Order $order){

        $amount=$order->items->sum(function($item){
                     return $item->price * $item->quantity;
                });

        \Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [
                            'name' => $order->products->name,
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' =>$order->products,
                ],
                // Add more line items if needed
            ],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('checkout'),
        ]);

        return redirect()->away($session->url);
    }


    // public function createStripePaymentIntent(Order $order){

    //      $amount=$order->items->sum(function($item){
    //         return $item->price * $item->quantity;
    //     });

    //     $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

    //     $paymentIntents=$stripe->paymentIntents->create([
    //         'amount' => $amount,
    //         'currency' => 'usd',
    //         'automatic_payment_methods' => ['card'],
    //     ]);

    //     return [
    //         'clientSecret' => $paymentIntents->client_secret,
    //     ];
    // }

    public function confirm(Request $request, Order $order){

        dd($request->all());

    }
}
