<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'currency_code'=>'required|string|size:3',
        ]);
        $baseCurrencyCode=config('app.currency');

        $currencycode=$request->input('currency_code');

        $cacheKey='currency_rates_' . $currencycode;
        
        $rate=Cache::get($cacheKey,0);

        if(!$rate){
            $converter=app('currency.converter');
            $rate=$converter->convert($baseCurrencyCode,$currencycode);

            Cache::put($cacheKey,$rate,now()->addMinutes(60));
        }
        Session::put('currency_code', $currencycode);
    
        return redirect()->back();
    }
}
