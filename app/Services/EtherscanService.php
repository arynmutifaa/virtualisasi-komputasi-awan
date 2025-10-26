<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EtherscanService
{
    public function getTransactions($address)
    {
        $response = Http::get(env('ETHERSCAN_API_URL'), [
            'chainid'   => env('ETHERSCAN_CHAIN_ID', 1), // default ke mainnet
            'module'    => 'account',
            'action'    => 'txlist',
            'address'   => $address,
            'page'      => 1,
            'offset'    => 10,
            'sort'      => 'desc',
            'apikey'    => env('ETHERSCAN_API_KEY'),
        ]);

        $json = $response->json();

        // ✅ Log hasil response ke storage/logs/laravel.log
        Log::info('Etherscan Response', $json);

        // sementara return full JSON biar bisa dump di controller
        return $json;
    }
}
