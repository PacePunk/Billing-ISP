<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Instruksi Pembayaran</h1>
            <p class="text-gray-500 text-sm mt-1">Selesaikan pembayaran agar internet aktif</p>
        </div>

        <div class="bg-blue-50 rounded-lg p-4 mb-6 border border-blue-100 text-center">
            <p class="text-sm text-gray-600 mb-1">Total Tagihan ({{ $invoice->invoice_number }})</p>
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Transfer ke Rekening Berikut:</h3>

            <div class="flex justify-between items-center bg-gray-50 p-3 rounded border mb-2">
                <div>
                    <p class="font-bold text-gray-800">BCA</p>
                    <p class="text-sm text-gray-600">a.n PT. Mitra Karsa Utama</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">1234567890</p>
                </div>
            </div>

            <div class="flex justify-between items-center bg-gray-50 p-3 rounded border">
                <div>
                    <p class="font-bold text-gray-800">Mandiri</p>
                    <p class="text-sm text-gray-600">a.n PT. Mitra Karsa Utama</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">0987654321</p>
                </div>
            </div>
        </div>

        @php
            // Format pesan WA otomatis
            $pesan =
                'Halo Admin, saya ingin konfirmasi pembayaran internet untuk No. Invoice: *' .
                $invoice->invoice_number .
                '* dengan nominal *Rp ' .
                number_format($invoice->amount, 0, ',', '.') .
                '*. Berikut saya lampirkan bukti transfernya.';
            $linkWA = 'https://wa.me/6285799959293?text=' . urlencode($pesan);
        @endphp

        <a href="{{ $linkWA }}" target="_blank"
            class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 mb-3">
            Konfirmasi via WhatsApp
        </a>

        <a href="{{ url()->previous() }}"
            class="block w-full text-center text-gray-500 hover:text-gray-700 text-sm mt-4">
            Kembali ke Dashboard
        </a>
    </div>

</body>

</html>
