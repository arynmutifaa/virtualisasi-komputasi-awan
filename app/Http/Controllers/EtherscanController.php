<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EtherscanService;

class EtherscanController extends Controller
{
    protected $etherscan;

    public function __construct(EtherscanService $etherscan)
    {
        $this->etherscan = $etherscan;
    }

    public function index()
    {
        return view('etherscan.index');
    }

    public function check(Request $request)
    {
        $address = $request->input('address');
        $data = $this->etherscan->getTransactions($address);

        return view('etherscan.index', [
            'transactions' => $data['result'] ?? [],
            'address' => $address
        ]);

    }

}
