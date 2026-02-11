<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pelanggan ISP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600 mb-2">My ISP Portal</h1>
            <p class="text-gray-500">Masuk untuk cek tagihan & status internet</p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('client.check') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                    Nomor WhatsApp / HP Terdaftar
                </label>
                <input type="text" name="phone_number" id="phone" required
                    class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 transition"
                    placeholder="Contoh: 08123456789">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
                Masuk / Cek Status
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">
            Butuh bantuan? Hubungi CS di 0812-3333-4444
        </p>
    </div>

</body>

</html>
