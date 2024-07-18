<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConvert
{
    private $apiKey;
    protected $baseUrl='https://free.currconv.com/api/v7/';
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }
    public function convert(string $form,string $to,float $amount=1): float
    {
        $q="{$form}_{$to}";
        $response= Http::baseUrl($this->baseUrl)
            ->get('/convert',[
                'q'=>$q,
                //'compact'=>'y',
                'apiKey'=>$this->apiKey,
            ]);
        $result=$response->json();
        //dd($result);
        if (isset($result[$q]['val'])) {
            return $result[$q]['val'] * $amount;
        }
        return 0; 
    }
}