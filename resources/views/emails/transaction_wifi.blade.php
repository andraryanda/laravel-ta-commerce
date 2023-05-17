<!DOCTYPE html>
<html>

<head>
    <title>Transaction Confirmation</title>
    <style type="text/css">
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Main content styles */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            border: 1px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .subtotal {
            font-weight: bold;
            text-align: right;
        }

        .total {
            font-weight: bold;
            text-align: right;
            font-size: 1.2rem;
            padding-top: 10px;
        }

        .thanks {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
        }

        p {
            margin-bottom: 1em;
        }

        .store-name {
            margin-bottom: 20px;
        }

        .invoice {
            margin-bottom: 10px;
        }

        .transaction-id,
        .payment-status,
        .shipping-price,
        .transaction-date,
        .user-profile {
            margin-bottom: 5px;
        }

        .user-name,
        .user-email,
        .user-address {
            margin-bottom: 10px;
        }

        /* Tablet styles */
        @media only screen and (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }

        /* Mobile styles */
        @media only screen and (max-width: 480px) {
            .content {
                padding: 10px;
            }

            table {
                font-size: 0.8rem;
            }

            th,
            td {
                padding: 5px;
            }
        }
    </style>
</head>

{{-- <body>
    <div class="container">
        <div class="header">
            <h1>Transaction Wifi Confirmation</h1>
        </div>
        <div class="content">

            <div class="container">
                <h1 class="store-name">Al's Store</h1>
                <h2 class="invoice">Invoice</h2>
                <p class="transaction-id">Transaction ID: {{ $transactionWifi->id }}</p>
                <p class="payment-status">Status Pembayaran: {{ $transactionWifi->status }}</p>
                <p class="expired-date">Expired Date: {{ $transactionWifi->expired_wifi }}</p>
                <p class="transaction-date">Tanggal Transaksi: {{ $transactionWifi->created_at->format('d/m/Y') }}</p>
                <br>
                <h3 class="user-profile">Profil User</h3>
                <p class="user-name">Nama: {{ $user->name }}</p>
                <p class="user-email">Email: {{ $user->email }}</p>
                <p class="user-address">Alamat: {{ $transactionWifi->items->address }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Total Harga Wifi</th>
                        <th>Total Pembayaran Wifi</th>
                        <th>Status Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $transactionWifi->product->name }}</td>
                        <td>Rp {{ number_format($transactionWifi->total_price_wifi) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach ($transactionWifi->wifi_items as $wifiItem)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $wifiItem->payment_transaction }}</td>
                            <td>{{ $wifiItem->payment_status }}</td>
                            <td>{{ $wifiItem->payment_method }}</td>
                            <td>{{ $wifiItem->description }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="total"><strong>Total Pembayaran Wifi</strong></td>
                        <td class="total"><strong>Rp {{ number_format($transactionWifi->total_price_wifi) }}</strong>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <br>
            <p>Thank you for using our WiFi service!</p>
        </div>
        <div class="thanks">
            <p>Regards,
                <br><br>
                <strong>Al's Store Team</strong>
            </p>
        </div>
    </div>
</body> --}}

<body>
    <div class="container">
        <div class="header">
            <h1>Transaction Wifi Confirmation</h1>
        </div>
        <div class="content">

            <div class="container">
                <h1 class="store-name">Al's Store</h1>
                <h2 class="invoice">Invoice</h2>
                <p class="transaction-id">Transaction ID: {{ $transactionWifi->id }}</p>
                <p class="payment-status">Status Pembayaran: {{ $transactionWifi->status }}</p>
                <p class="expired-date">Expired Date: {{ $transactionWifi->expired_wifi->format('d/m/Y') }}</p>
                <p class="transaction-date">Tanggal Transaksi: {{ $transactionWifi->created_at->format('d/m/Y') }}</p>
                <br>
                <h3 class="user-profile">Profil User</h3>
                <p class="user-name">Nama: {{ $user->name }}</p>
                <p class="user-email">Email: {{ $user->email }}</p>
                <p class="user-address">Alamat: {{ $transactionWifi->items->address }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Total Harga Wifi</th>
                        <th>Payment Transaction</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionWifi->wifi_items as $wifiItem)
                        <tr>
                            <td>{{ $wifiItem->product->name }}</td>
                            <td>Rp {{ number_format($transactionWifi->total_price_wifi) }}</td>
                            <td>{{ $wifiItem->payment_transaction }}</td>
                            <td>{{ $wifiItem->payment_method }}</td>
                            <td>{{ $wifiItem->payment_status }}</td>
                            <td>{{ $wifiItem->description ?? 'Tidak ada catatan..' }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="total"><strong>Total Pembayaran Wifi</strong></td>
                        <td class="total"><strong>Rp {{ number_format($transactionWifi->total_price_wifi) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <br>
            <p>Thank you for using our WiFi service!</p>
        </div>
        <div class="thanks">
            <p>Regards,
                <br><br>
                <strong>Al's Store Team</strong>
            </p>
        </div>
    </div>
</body>



</html>
