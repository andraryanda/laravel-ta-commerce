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
            background-color: #00ff84;
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

<body>
    <div class="container">
        <div class="header">
            <h1>Transaction Success Confirmation</h1>
        </div>
        <div class="content">

            <div class="container">
                <h1 class="store-name">AL-N3T Support Gesitnet</h1>
                <h2 class="invoice">Invoice</h2>
                <p class="transaction-id">Transaction ID: {{ $transaction->id }}</p>
                <p class="payment-status">Status Pembayaran: <strong>{{ $transaction->status }}</strong></p>
                <p class="shipping-price">Shipping Price: {{ $transaction->shipping_price }}</p>
                <p class="transaction-date">Tanggal Transaksi: {{ $transaction->created_at->format('d/m/Y') }}</p>
                <br>
                <h3 class="user-profile">Profil User</h3>
                <p class="user-name">Nama: {{ $user->name }}</p>
                <p class="user-email">Email: {{ $user->email }}</p>
                <p class="user-address">Alamat: {{ $transaction->address }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Produk</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->product->price) }}</td>
                            <td>Rp {{ number_format($item->quantity * $item->product->price) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="subtotal">Subtotal</td>
                        <td>Rp {{ number_format($transaction->total_price) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Ongkir</td>
                        <td>Rp {{ number_format($transaction->shipping_price) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="total"><strong>Total Pembayaran</strong></td>
                        <td class="total"><strong>Rp
                                {{ number_format($transaction->total_price + $transaction->shipping_price) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <p>Thank you for shopping with us!</p>
        </div>
        <div class="thanks">
            <p>Regards,
                <br><br>
                <strong>AL-N3T Support Gesitnet Team</strong>
            </p>
        </div>
    </div>
</body>

</html>
