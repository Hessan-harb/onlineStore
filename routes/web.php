<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ProductFrontController;
use App\Http\Controllers\Front\ShopGridController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/products',[ProductFrontController::class,'index'])->name('product.index');
Route::get('/products/{product:slug}',[ProductFrontController::class,'show'])->name('product.show');
Route::get('/shopgrid',[ShopGridController::class,'index'])->name('shopgrid.index');
Route::get('/shopgrid/products/{category}',[ShopGridController::class,'show'])->name('shopgrid.products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ds',function(){
    return view('dashboard');
});
require __DIR__.'/auth.php';

//dashboard routes require authentication routes

require __DIR__.'/dashboard.php';

Route::resource('/cart',CartController::class);

Route::get('checkout',[CheckoutController::class,'create'])->name('checkout');
Route::post('checkout',[CheckoutController::class,'store']);
///////////////////////////////payment////////////////////////
Route::get('orders/{order}/pay',[PaymentController::class,'create'])
    ->name('orders.payment.create');

Route::post('orders/{order}/stripe/payment/payment-intent',[PaymentController::class,'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback',[PaymentController::class,'confirm'])
    ->name('stripe.return');

Route::post('/currency',[CurrencyConController::class,'store'])
    ->name('currency.store');
    
    // Route::group(['prefix' => 'myfatoorah'], function () {
    //     // Route to redirect users to MyFatoorah invoice URL
    //     Route::get('/', [MyFatoorahController::class,'index'])->name('myfatoorah.index');
    
    //     // Route to handle callback from MyFatoorah
    //     Route::post('/callback', [MyFatoorahController::class,'callback'])->name('myfatoorah.callback');
    
    //     // Route to display checkout page
    //     Route::get('/checkout',  [MyFatoorahController::class,'checkout'])->name('myfatoorah.checkout');
    
    //     // Route to handle webhook from MyFatoorah
    //     Route::post('/webhook',  [MyFatoorahController::class,'webhook'])->name('myfatoorah.webhook');
    // });   