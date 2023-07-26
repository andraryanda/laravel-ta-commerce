<!DOCTYPE html>
<html>

<head>
    <title>Transaction PDF</title>
    <style>
        /* Gaya CSS untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">AL-N3T Support Gesitnet</h2>
    <hr>
    <h2 style="text-align: center;">Laporan All Transaksi Produk</h2>
    <p style="text-align: justify;">
        Laporan ini berisi informasi terkait setiap transaksi, termasuk detail produk, harga, kuantitas, total biaya,
        metode pembayaran, status transaksi, dan tanggal transaksi.
    </p>
    <!-- Tabel untuk data transaksi lainnya -->
    <table>
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Nama Pengguna</th>
            <th>Alamat</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Qty</th>
            <th>Total Harga</th>
            <th>Biaya Pengiriman</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Transaksi</th>
        </tr>
        @php
            $totalOmset = 0;
            $successCount = 0;
            $pendingCount = 0;
            $cancelledCount = 0;
        @endphp
        @foreach ($transactions as $index => $transaction)
            @php
                if ($transaction->status === 'SUCCESS') {
                    $totalOmset += $transaction->total_price;
                    $successCount++;
                } elseif ($transaction->status === 'PENDING') {
                    $pendingCount++;
                } elseif ($transaction->status === 'CANCELLED') {
                    $cancelledCount++;
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->name }}</td>
                <td>{{ $transaction->address }}</td>
                <td>{{ $transaction->product_name }}</td>
                <td>{{ number_format($transaction->product_price, 0, ',', '.') }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                <td>{{ $transaction->shipping_price }}</td>
                <td>{{ $transaction->status }}</td>
                <td>{{ $transaction->payment }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y H:i:s') }}</td>
            </tr>
        @endforeach

        <!-- Tabel untuk data total omset dan jumlah status -->
        <tr>
            <td colspan="7" style="text-align: right;"><strong>Total Omset (SUCCESS):</strong></td>
            <td colspan="5" style="text-align: right;">{{ number_format($totalOmset, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;"><strong>Jumlah Status:</strong></td>
            <td colspan="5" style="text-align: right;">SUCCESS: {{ $successCount }} | PENDING: {{ $pendingCount }}
                |
                CANCELLED: {{ $cancelledCount }}</td>
        </tr>
    </table>
</body>

</html>
