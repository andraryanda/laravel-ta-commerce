<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Transaksi</title>
    <link rel="shortcut icon" href="{{ asset('logo/alnet.jpg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .btn-purple {
            background-color: #7f00ff;
            color: #fff;
            border-color: #7f00ff;
        }

        .btn-purple:hover {
            background-color: #6400e4;
            color: #fff;
            border-color: #6400e4;
        }

        .btn-purple:focus,
        .btn-purple.focus {
            box-shadow: 0 0 0 0.2rem rgba(127, 0, 255, 0.5);
        }

        .btn-purple.disabled,
        .btn-purple:disabled {
            background-color: #7f00ff;
            color: #fff;
            border-color: #7f00ff;
        }
    </style>
</head>

<body style="background-color: #eaeaea;">
    <div class="container mt-5">
        <h1 class="text-center my-3">Status Transaksi Midtrans</h1>

        <div class="text-center">
            <a href="{{ route('dashboard.transaction.indexSuccess') }}"
                class="btn btn-purple my-3 mr-2 text-white rounded-pill">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-circle" alt="Back"
                        width="25">
                    <p class="m-0 mx-2"> Back</p>
                </div>
            </a>
            <a href="{{ route('dashboard.transaction.show', Crypt::encrypt($transaction->id)) }}"
                class="btn btn-primary fw-bolder">Detail Transaksi Website</a>
            <a href="{{ 'https://dashboard.sandbox.midtrans.com/transactions/' . $transactionStatus['transaction_id'] }}"
                class="btn btn-warning fw-bolder" target="_blank">Detail Transaksi Midtrans</a>

        </div>
        <div class="card shadow">
            <div class="card-header text-center">
                <h5 class="font-weight-bold">Customer Detail</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong>ID Transaction</strong></td>
                            <td>: {{ $transaction->id }} - (<b>ID Website Transaksi</b>)</td>
                        </tr>
                        <tr>
                            <td><strong>Order ID</strong></td>
                            <td>: {{ $transaction->order_id }} - (<b>ID MIDTRANS Transaksi</b>)</td>
                        </tr>
                        <tr>
                            <td><strong>User Address</strong></td>
                            <td colspan="2">: {{ $transaction->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Price</strong></td>
                            <td colspan="2">: Rp {{ number_format($transaction->total_price, 2, ',', '.') }}</td>

                        </tr>
                        <tr>
                            <td><strong>Shipping Price</strong></td>
                            <td colspan="2">: {{ $transaction->shipping_price }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td colspan="2">
                                : <span
                                    class="badge
                                    @if ($transaction->status === 'SUCCESS') bg-success
                                    @elseif ($transaction->status === 'PENDING')
                                        bg-warning
                                    @elseif ($transaction->status === 'CANCELLED')
                                        bg-danger @endif">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Payment</strong></td>
                            <td colspan="2">: {{ $transaction->payment }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="card my-3 shadow">
            <div class="card-header text-center">
                <h5 class="font-weight-bold">Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 my-2">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Order ID</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if (isset($transactionStatus['order_id']))
                                    @if (is_array($transactionStatus['order_id']))
                                        @foreach ($transactionStatus['order_id'] as $item)
                                            <p>{{ $item }}</p>
                                        @endforeach
                                    @else
                                        {{ $transactionStatus['order_id'] }}
                                    @endif
                                @else
                                    Order ID not found.
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 my-2">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Gross Amount</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if (isset($transactionStatus['gross_amount']))
                                    @if (is_array($transactionStatus['gross_amount']))
                                        @foreach ($transactionStatus['gross_amount'] as $item)
                                            <p>Rp {{ number_format($item, 2, ',', '.') }}</p>
                                        @endforeach
                                    @else
                                        Rp {{ number_format($transactionStatus['gross_amount'], 2, ',', '.') }}
                                    @endif
                                @else
                                    Gross Amount not found.
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 my-2">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Payment Method</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if (isset($transactionStatus['payment_type']))
                                    @if (is_array($transactionStatus['payment_type']))
                                        @foreach ($transactionStatus['payment_type'] as $item)
                                            <p>{{ ucwords(str_replace('_', ' ', $item)) }}</p>
                                        @endforeach
                                    @else
                                        {{ ucwords(str_replace('_', ' ', $transactionStatus['payment_type'])) }}
                                    @endif
                                @else
                                    Payment Type not found.
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 my-2">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Transaction Status</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if (isset($transactionStatus['transaction_status']))
                                    @if (is_array($transactionStatus['transaction_status']))
                                        @foreach ($transactionStatus['transaction_status'] as $item)
                                            <p>
                                                {{ ucwords(str_replace('_', ' ', $item)) }}
                                                @if ($item === 'success')
                                                    (Success)
                                                @endif
                                            </p>
                                        @endforeach
                                    @else
                                        {{ ucwords(str_replace('_', ' ', $transactionStatus['transaction_status'])) }}
                                        @if ($transactionStatus['transaction_status'] === 'settlement')
                                            (Success)
                                        @endif
                                    @endif
                                @else
                                    Transaction Status not found.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 my-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="font-weight-bold">Order Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table ">
                            <tbody>
                                <tr>
                                    <th>Order ID</th>
                                    <td>
                                        @if (isset($transactionStatus['order_id']))
                                            {{ $transactionStatus['order_id'] }}
                                        @else
                                            Order ID not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>
                                        @if (isset($transactionStatus['payment_type']))
                                            {{ ucwords(str_replace('_', ' ', $transactionStatus['payment_type'])) }}
                                        @else
                                            Payment Type not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>
                                        @if (isset($transactionStatus['gross_amount']))
                                            Rp {{ number_format($transactionStatus['gross_amount'], 2, ',', '.') }}
                                        @else
                                            Amount not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>
                                        @if (isset($transactionStatus['transaction_id']))
                                            {{ $transactionStatus['transaction_id'] }}
                                        @else
                                            Transaction ID not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Transaction Time</th>
                                    <td>
                                        @if (isset($transactionStatus['transaction_time']))
                                            @php
                                                $transactionTime = \Carbon\Carbon::parse($transactionStatus['transaction_time'])
                                                    ->setTimezone('Asia/Jakarta')
                                                    ->locale('id_ID');
                                                $formattedTransactionTime = $transactionTime->isoFormat('dddd, D MMMM Y - hh:mm (A)');
                                            @endphp
                                            {{ $formattedTransactionTime }}
                                        @else
                                            Transaction Time not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Settlement Time</th>
                                    <td>
                                        @if (isset($transactionStatus['settlement_time']))
                                            @php
                                                $settlementTime = \Carbon\Carbon::parse($transactionStatus['settlement_time'])
                                                    ->setTimezone('Asia/Jakarta')
                                                    ->locale('id_ID');
                                                $formattedSettlementTime = $settlementTime->isoFormat('dddd, D MMMM Y - hh:mm (A)');
                                            @endphp
                                            {{ $formattedSettlementTime }}
                                        @else
                                            Settlement Time not found.
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 my-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="font-weight-bold">Customer Detail</h5>
                    </div>
                    <div class="card-body">
                        <table class="table ">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>
                                        {{ $transaction->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>
                                        {{ $transaction->user->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        {{ $transaction->user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>
                                        {{ $transaction->address }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="font-weight-bold">Detail Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Virtual Account</th>
                                    <td>
                                        @if (isset($transactionStatus['va_numbers']))
                                            @foreach ($transactionStatus['va_numbers'] as $va)
                                                <p>{{ $va['va_number'] }}</p>
                                            @endforeach
                                        @else
                                            Virtual Account not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Acquiring Bank</th>
                                    <td>
                                        @if (isset($transactionStatus['va_numbers']))
                                            @foreach ($transactionStatus['va_numbers'] as $va)
                                                <p class="text-uppercase">{{ $va['bank'] }}</p>
                                            @endforeach
                                        @else
                                            Acquiring Bank not found.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Expiry Time</th>
                                    <td>
                                        @if (isset($transactionStatus['expiry_time']))
                                            @php
                                                $expiryTime = \Carbon\Carbon::parse($transactionStatus['expiry_time'])
                                                    ->setTimezone('Asia/Jakarta')
                                                    ->locale('id_ID');
                                                $formattedExpiryTime = $expiryTime->isoFormat('dddd, D MMMM Y - hh:mm (A)');
                                            @endphp
                                            {{ $formattedExpiryTime }}
                                        @else
                                            Expiry Time not found.
                                        @endif
                                    </td>




                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mt-4 mb-5 shadow">
            <div class="card-header text-center">
                <a class="font-weight-bold d-block text-decoration-none text-black fw-bolder" data-bs-toggle="collapse"
                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Transaction Information
                    <svg class="bi bi-chevron-down float-end" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 11.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" />
                    </svg>
                </a>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                @foreach ($transactionStatus as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td colspan="2">
                                            @if ($key === 'va_numbers')
                                                @if (is_array($value))
                                                    @foreach ($value as $va)
                                                        <p><strong>Bank:</strong> {{ $va['bank'] }}</p>
                                                        <p><strong>VA Number:</strong> {{ $va['va_number'] }}</p>
                                                    @endforeach
                                                @else
                                                    {{ $value }}
                                                @endif
                                            @else
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>







{{-- <!DOCTYPE html>
<html>

<head>
    <title>Status Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Status Transaksi Midtrans</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>transaction_id</td>
                        <td>{{ $transactionStatus['transaction_id'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html> --}}
