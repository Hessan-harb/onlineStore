<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency
{
    public function __invoke(...$amount)
    {
        return static::format(...$amount);
    }

    public static function format($amount, $currency = null)
    {
        $baseCurrency = config('app.currency', 'USD');

        $locale = config('app.locale');

        if ($currency === null) {
            $currency = Session::get('currency_code', $baseCurrency);
        }

        if ($currency !== $baseCurrency) {
            $rate = Cache::get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }

        $formattedAmount = number_format($amount, 2);

        return $formattedAmount . ' ' . $currency;
    }
}
