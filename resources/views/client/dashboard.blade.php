<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - {{ $subscription->customer->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen pb-10">

    <div class="bg-white shadow">
        <div class="max-w-3xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">My ISP Portal</h1>
            <a href="{{ route('client.login') }}" class="text-sm text-red-500 hover:text-red-700">Keluar</a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 py-8">

        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Halo, {{ $subscription->customer->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $subscription->customer->phone_number }}</p>
                    </div>

                    @if ($unpaidInvoices->count() > 0)
                        <span
                            class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full animate-pulse">TERISOLIR</span>
                    @elseif ($subscription->status == 'active')
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">INTERNET
                            AKTIF</span>
                    @elseif($subscription->status == 'isolated')
                        <span
                            class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full animate-pulse">TERISOLIR</span>
                    @else
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full">NONAKTIF</span>
                    @endif
                </div>

                <div class="border-t border-gray-100 pt-4 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Paket Saat Ini</p>
                        <p class="font-medium text-gray-800">{{ $subscription->package->name }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($subscription->price, 0, ',', '.') }} /
                            bulan</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Jatuh Tempo</p>
                        <p class="font-medium text-gray-800">Tanggal {{ $subscription->due_date }} setiap bulan</p>
                    </div>
                </div>
            </div>

            @if ($unpaidInvoices->count() > 0 || $subscription->status == 'isolated')
                <div class="bg-red-600 text-white p-4 text-center">
                    <p class="font-bold">⚠️ LAYANAN INTERNET ANDA TERHENTI</p>
                    <p class="text-sm opacity-90">Mohon lunasi tagihan di bawah ini agar internet otomatis menyala
                        kembali.</p>
                </div>
            @endif
        </div>

        <h3 class="text-lg font-bold text-gray-700 mb-3">Tagihan Belum Dibayar</h3>

        @if ($unpaidInvoices->count() > 0)
            @foreach ($unpaidInvoices as $invoice)
                <div
                    class="bg-white rounded-lg shadow-sm border-l-4 border-orange-500 p-5 mb-4 flex flex-col md:flex-row justify-between items-center transition hover:shadow-md">
                    <div class="mb-4 md:mb-0">
                        <p class="text-xs text-gray-400">Nomor Invoice: {{ $invoice->invoice_number }}</p>
                        <p class="text-2xl font-bold text-gray-800">Rp
                            {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-red-500 mt-1">Status: Belum Lunas</p>
                    </div>

                    <a href="{{ route('client.bayar', $invoice->id) }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded shadow-lg transform transition hover:-translate-y-1">
                        BAYAR SEKARANG &rarr;
                    </a>
                </div>
            @endforeach
        @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-8 text-center">
                <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h4 class="text-gray-800 font-bold">Terima Kasih!</h4>
                <p class="text-gray-600 text-sm">Tidak ada tagihan yang harus dibayar saat ini.</p>
            </div>
        @endif

    </div>
</body>

</html>
