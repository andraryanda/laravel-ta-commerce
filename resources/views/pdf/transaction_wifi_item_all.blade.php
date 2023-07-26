<!DOCTYPE html>
<html>

<head>
    <title>Transaction WiFi Item PDF</title>
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
    <h2 style="text-align: center;">Laporan All Transaksi WiFi Items</h2>
    <p style="text-align: justify;">
        Laporan ini berisi informasi terkait setiap transaksi WiFi, termasuk detail produk, harga, kuantitas, total
        biaya,
        metode pembayaran, status pembayaran, dan tanggal transaksi.
    </p>
    <!-- Tabel untuk data transaksi WiFi lainnya -->
    <div class="table-1">
        <table>
            <tr>
                <th>No.</th>
                <th>Transaction WiFi ID</th>
                <th>Nama Produk</th>
                <th>Name Customer</th>
                <th>Total Harga WiFi</th>
                <th>Status Pembayaran</th>
                <th>Total Pembayaran Customer</th>
                <th>Metode Pembayaran</th>
                <th>Bank Pembayaran</th>
                <th>Deskripsi</th>
                <th>Created At</th>
            </tr>
            @php
                $totalOmset = 0;
                $paidOmset = 0;
                $bankTransferCount = 0;
                $manualCount = 0;
                
                // Mengurutkan data berdasarkan nama customer
                $sortedItems = $items->sortBy('user.name');
            @endphp
            @foreach ($sortedItems as $item)
                @php
                    $totalOmset += $item->payment_transaction; // Use payment_transaction instead of total_price_wifi
                    if ($item->payment_status === 'PAID') {
                        $paidOmset += $item->payment_transaction; // Use payment_transaction instead of total_price_wifi
                    }
                    
                    if ($item->payment_method === 'BANK TRANSFER') {
                        $bankTransferCount++;
                    } elseif ($item->payment_method === 'MANUAL') {
                        $manualCount++;
                    }
                    
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->transaction_wifi_id }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ number_format($item->wifis->total_price_wifi, 0, ',', '.') }}</td>
                    <td>{{ $item->payment_status === 'PAID' ? 'Sudah Dibayar' : 'Belum Bayar' }}</td>
                    <td
                        style="color: {{ $item->payment_transaction !== $item->wifis->total_price_wifi ? '#ff0000' : '' }}">
                        {{ number_format($item->payment_transaction, 0, ',', '.') }}
                    </td>

                    <td
                        style="{{ $item->payment_method === 'MANUAL' ? 'background-color: #FFD700;' : ($item->payment_method === 'BANK TRANSFER' ? 'background-color: #99ff99;' : '') }}">
                        {{ $item->payment_method }}
                    </td>
                    <td style="{{ empty($item->payment_bank) ? 'background-color: #ffff99;' : '' }}">
                        {{ $item->payment_bank }}
                    </td>
                    <td>{{ $item->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="table-2" style="page-break-before: always;">
        <!-- Memisahkan tabel kedua dengan menggunakan <page> -->
        <page>
            {{-- <br><br> <!-- Add spacing between tables --> --}}
            <h2 style="text-align: center;">AL-N3T Support Gesitnet</h2>
            <hr>
            <h2 style="text-align: center;">Laporan All Transaksi WiFi Items (Lanjutan)</h2>
            <!-- Menampilkan Total Omset dan Jumlah Status -->
            <p style="text-align: justify;">Tabel dibawah berisi informasi tentang total omset dan jumlah pembayaran
                berdasarkan
                metode pembayaran (MANUAL dan BANK TRANSFER).</p>
            <table>
                <tr>
                    <td colspan="11" style="text-align: center; background-color: #f2f2f2;"><strong>Pendapatan Omset
                            Wifi
                            Bulanan</strong></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Total Omset:</strong></td>
                    <td colspan="6">{{ number_format($totalOmset, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Omset Sudah Dibayar (PAID):</strong></td>
                    <td colspan="6">{{ number_format($paidOmset, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Jumlah Pembayaran MANUAL:</strong></td>
                    <td colspan="6">{{ $manualCount }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Jumlah Pembayaran BANK TRANSFER:</strong></td>
                    <td colspan="6">{{ $bankTransferCount }}</td>
                </tr>
            </table>
        </page>
    </div>

    <!-- Table for WiFi Status -->
    <div class="table-3" style="page-break-before: always;">
        <h2 style="text-align: center;">AL-N3T Support Gesitnet</h2>
        <hr>
        <h2 style="text-align: center;">Laporan All Transaksi WiFi - Masa Wifi Berakhir (Lanjutan)</h2>
        <!-- Display WiFi Status -->
        <p style="text-align: justify; ">Tabel di bawah menampilkan informasi tentang status masa berakhir WiFi.</p>

        <table>
            <tr>
                <th>No.</th>
                <th>ID Wifi Utama</th>
                <th>Name Customer</th>
                <th>Nama Produk Wifi</th>
                <th>Total Harga WiFi</th>
                <th>Status WiFi</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($wifi_utama as $wifi)
                @php
                    // Calculate remaining days for WiFi status
                    $statusWiFi = '';
                    $expiredWiFi = Carbon\Carbon::parse($wifi->expired_wifi);
                    $remainingDays = $expiredWiFi->diffInDays(Carbon\Carbon::now());
                    
                    // Set background color based on remaining days
                    $background = '';
                    if ($remainingDays > 0) {
                        if ($remainingDays <= 3) {
                            $statusWiFi = 'Aktif (Masa Wifi berakhir dalam ' . $remainingDays . ' hari)';
                            $background = 'background-color: #ffff00;'; // Yellow background
                        } else {
                            $statusWiFi = 'Aktif (Masa Wifi berakhir pada ' . $expiredWiFi->translatedFormat('l, d F Y') . ')';
                            $background = ''; // Default background
                        }
                    } else {
                        $statusWiFi = 'Berakhir';
                        $background = 'background-color: #ff0000;'; // Red background
                    }
                @endphp
                <tr style="{{ $background }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $wifi->id }}</td>
                    <td>{{ $wifi->user->name }}</td>
                    <td>
                        @foreach ($wifi->wifi_items as $item)
                            {{ $item->product->name }}
                        @endforeach
                    </td>
                    <td>{{ number_format($wifi->total_price_wifi, 0, ',', '.') }}</td>
                    <td>{{ $statusWiFi }}</td>
                </tr>
            @endforeach
        </table>
    </div>










    <div class="table-4" style="page-break-before: always;">
        <page>
            {{-- <br><br> <!-- Add spacing between tables --> --}}
            <h2 style="text-align: center;">AL-N3T Support Gesitnet</h2>
            <hr>
            <h2 style="text-align: center;">Laporan All Transaksi WiFi Items - Omset Tahun (Lanjutan)</h2>
            <!-- Display total omset PAID per year -->
            <p style="text-align: justify; ">Tabel dibawah menampilkan informasi tentang total omset yang sudah dibayar
                (PAID)
                per
                tahun.</p>
            <table>
                <tr>
                    <td colspan="2" style="text-align: center; background-color: #f2f2f2;"><strong>Omset Sudah
                            Dibayar
                            (PAID)
                            per Tahun:
                        </strong></td>
                </tr>
                @foreach ($totalOmsetPaidPerYear as $year => $omset)
                    <tr>
                        <td style="text-align: right;">Tahun {{ $year }}:</td>
                        <td>{{ number_format($omset, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </table>
        </page>
    </div>
</body>

</html>
