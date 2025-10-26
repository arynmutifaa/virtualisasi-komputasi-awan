<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Etherscan V2 Checker - Full Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-blue-700 mb-6">
            Ethereum Address Checker (Etherscan V2 API)
        </h1>

        {{-- Form Input --}}
        <form method="POST" action="{{ route('etherscan.check') }}" class="flex gap-3 mb-6">
            @csrf
            <input 
                type="text" 
                name="address" 
                placeholder="Enter ETH Address"
                value="{{ old('address', $address ?? '') }}"
                required
                class="flex-1 p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <button 
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition"
            >
                Check
            </button>
        </form>

        {{-- Result --}}
        @isset($address)
            <h2 class="text-lg font-semibold mb-4">
                Transactions for: <span class="text-blue-600">{{ $address }}</span>
            </h2>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-2 border">Tx Hash</th>
                            <th class="px-4 py-2 border">Block</th>
                            <th class="px-4 py-2 border">Age</th>
                            <th class="px-4 py-2 border">From</th>
                            <th class="px-4 py-2 border">To</th>
                            <th class="px-4 py-2 border">Value (ETH)</th>
                            <th class="px-4 py-2 border">Gas Used</th>
                            <th class="px-4 py-2 border">Gas Price (Gwei)</th>
                            <th class="px-4 py-2 border">Txn Fee (ETH)</th>
                            <th class="px-4 py-2 border">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($transactions as $tx)
                            <tr class="hover:bg-gray-50">
                                {{-- Tx Hash --}}
                                <td class="px-4 py-2 border text-blue-600">
                                    <a href="https://etherscan.io/tx/{{ $tx['hash'] }}" target="_blank">
                                        {{ substr($tx['hash'], 0, 12) }}...
                                    </a>
                                </td>
                                {{-- Block --}}
                                <td class="px-4 py-2 border">{{ $tx['blockNumber'] }}</td>
                                {{-- Age --}}
                                <td class="px-4 py-2 border">
                                    {{ \Carbon\Carbon::createFromTimestamp($tx['timeStamp'])->diffForHumans() }}
                                </td>
                                {{-- From --}}
                                <td class="px-4 py-2 border text-red-600">{{ $tx['from'] }}</td>
                                {{-- To --}}
                                <td class="px-4 py-2 border text-green-600">{{ $tx['to'] }}</td>
                                {{-- Value in ETH --}}
                                <td class="px-4 py-2 border">
                                    {{ number_format($tx['value'] / 1e18, 8) }}
                                </td>
                                {{-- Gas Used --}}
                                <td class="px-4 py-2 border">{{ $tx['gasUsed'] }}</td>
                                {{-- Gas Price in Gwei --}}
                                <td class="px-4 py-2 border">
                                    {{ number_format($tx['gasPrice'] / 1e9, 2) }} Gwei
                                </td>
                                {{-- Txn Fee --}}
                                <td class="px-4 py-2 border">
                                    {{ number_format(($tx['gasPrice'] * $tx['gasUsed']) / 1e18, 8) }}
                                </td>
                                {{-- Status --}}
                                <td class="px-4 py-2 border">
                                    @if($tx['isError'] === "0")
                                        <span class="text-green-600 font-semibold">Success</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-gray-500">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endisset
    </div>
</body>
</html>
