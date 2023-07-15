<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css') }}" rel="stylesheet" />
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js') }}"></script>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-top: 20px;
            border-top: 2px solid #000;
        }

        .header .logo {
            width: 100%;
            height: 50px;
        }

        .header h1 {
            font-size: 36px;
            margin: 0;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info p {
            margin: 0;
        }

        .info .left {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 30px;
        }

        .total strong {
            font-size: 24px;
            margin-right: 10px;
        }

        .total p {
            font-size: 20px;
            margin: 0;
        }

        .italic-custom {
            font-style: italic;
        }

        .text-right-custom {
            text-align: right;
            margin-bottom: 5px;
        }

        .text-success {
            color: white;
            font-size: 14px;
            font-weight: bold;
            background-color: #39c552;
            padding: 5px;
        }

        .text-danger {
            color: white;
            font-size: 14px;
            font-weight: bold;
            background-color: rgb(217, 52, 52);
            padding: 5px;
        }

        .text-pending {
            color: white;
            font-size: 14px;
            font-weight: bold;
            background-color: rgb(179, 179, 44);
            padding: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="logo" style="overflow: hidden;">
                @php
                    $imagePath = asset('icon/store.png');
                    $imageData = '';
                    $imageType = '';
                    
                    $allowedExtensions = ['png', 'jpg', 'jpeg']; // Ekstensi file gambar yang diizinkan
                    
                    // Mendapatkan ekstensi file gambar
                    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    
                    // Memeriksa apakah ekstensi file gambar diizinkan
                    if (in_array($extension, $allowedExtensions)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $imageType = 'image/' . $extension;
                    }
                @endphp

                <img src="data:{{ $imageType }};base64,{{ $imageData }}" alt="logo"
                    style="float: left; margin-right: 10px;" width="50">
                <h1 style="margin: 0;">Al's Store</h1>
            </div>
            <br>
            <h2>Invoice</h2>
        </div>
        <div class="info">
            <div class="left">
                <p>Transaction ID: {{ $transaction->id }}</p>
                <p>Status Pembayaran:
                    @if ($transaction->status == 'SUCCESS')
                        <span class="text-success">{{ $transaction->status }}</span>
                    @elseif ($transaction->status == 'CANCELLED')
                        <span class="text-danger">{{ $transaction->status }}</span>
                    @elseif ($transaction->status == 'PENDING')
                        <span class="text-pending">{{ $transaction->status }}</span>
                    @endif
                </p>
                <p>Shipping Price: {{ $transaction->shipping_price }}</p>
                <p>Tanggal Transaksi: {{ date('d/m/Y', strtotime($transaction->created_at)) }}</p>
            </div>
            <br>
            <div class="right">
                <h2><strong>Profil User</strong></h2>
                <p>Nama: {{ $transaction->user->name }}</p>
                <p>Email: {{ $transaction->user->email }}</p>
                <p>Alamat: {{ $transaction->address }}</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, '.', ',') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total text-right-custom">
            <h3><strong>Total Pembayaran:</strong></h3>
            <p class="mb-4">Rp {{ number_format($total, 0, '.', ',') }}</p>
        </div>
        <div class="mt-4">
            <p class="text-lg font-semibold">Terima kasih telah menjadi pelanggan kami!</p>
            <p class="mt-2 text-sm text-gray-700">Kami sangat menghargai kepercayaan Anda dan berharap dapat terus
                memberikan pelayanan terbaik. Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.</p>
            <p class="mt-2 text-sm text-gray-700"><strong>Al's Store: 085314005779</strong></p>
        </div>
        <div class="my-3 italic-custom">
            <p class="text-sm font-medium">Catatan:</p>
            <ul class="list-disc pl-5">
                <li class="text-sm">Disimpan sebagai bukti pembayaran yang SAH</li>
                <li class="text-sm">Uang yang sudah dibayarkan tidak dapat diminta kembali</li>
            </ul>
        </div>
    </div>
</body>

</html>
