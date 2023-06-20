{{-- <x-app-layout> --}}
<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>
    </x-slot>

    <x-slot name="slot">
        <x-slot name="styles">
            <style>
                #crudTable tbody tr:hover {
                    background-color: #f7fafc;
                    transition: all 0.3s ease-in-out;
                    /* background-color: rgba(0, 0, 0, 0.075); */
                }

                #crudTable:hover {
                    cursor: pointer;
                }

                #crudTable.hover:bg-gray-100 tbody tr:hover {
                    background-color: #edf2f7;
                }

                #crudTable tfoot input {
                    width: 100%;
                }
            </style>
        </x-slot>


        <x-slot name="script">


            {{-- count Rupiah --}}
            <script>
                function animateValue(el, start = 0, end = 0, is_price = false, duration = 800) {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;

                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        el.innerHTML = is_price ?
                            prettyPrice(Math.floor(progress * (end - start) + start)) :
                            prettyNum(Math.floor(progress * (end - start) + start))

                        // if not at end, continue
                        // if at end, return final number WITHOUT math operation to preserve decimals
                        if (progress < 1) window.requestAnimationFrame(step);
                        else el.innerHTML = is_price ?
                            this.prettyPrice(end) :
                            this.prettyNum(end)
                    };
                    window.requestAnimationFrame(step);
                }

                function prettyNum(value = 0) {
                    return value.toLocaleString('id-ID');
                    //   return value.toLocaleString('en-US');
                }

                function prettyPrice(value = 0) {
                    if (typeof value === 'string' && value.includes('Rp ')) {
                        value = this.numericCurrency(value);
                    }

                    // if 0, manually convert to currency. otherwise !Number is falsy and returns unformatted 0
                    if (value == 0) return 'Rp 0';

                    // preserve string and exit, no need for currency conversion
                    if (!Number(value)) return value;

                    return 'Rp ' + Number(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                }



                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.count-up').forEach(el => {
                        animateValue(el, 0, el.dataset.value, el.dataset.isPrice);
                    })
                })
            </script>
            {{-- count Biasa --}}
            <script>
                const counters = document.querySelectorAll('.counter');
                const speed = 200;

                counters.forEach(counter => {
                    const animate = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText.replace(/,/g, '');
                        const increment = Math.ceil(target / speed);
                        if (count < target) {
                            counter.innerText = (count + increment).toLocaleString('id-ID');
                            setTimeout(animate, 1);
                        } else {
                            counter.innerText = target.toLocaleString('id-ID');
                        }
                    }
                    animate();
                });
            </script>

            {{-- Chart --}}
            {!! $transactionChart->script() !!}
            {!! $userRegistrationChart->script() !!}
            {!! $productChart->script() !!}
            {!! $transactionPriceChart->script() !!}
        </x-slot>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-yellow-200 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total User Customer
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $users_customer_count }}">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-green-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Transaksi Sukses
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_success }}" data-is-price="true">
                        {{-- $ {{ $total_amount_success }}{{ __('.00') }} --}}
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-yellow-100 transition duration-300 ease-in-out">
                <div
                    class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Transaksi Pending
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_pending }}" data-is-price="true">
                        {{-- $ {{ $total_amount_pending }}{{ __('.00') }} --}}
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-blue-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Transaction
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $new_transaction }}">
                        0
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Selamat datang,
                {{ Auth::user()->name . ' || ' . Auth::user()->email }}!</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Anda telah berhasil login ke halaman dashboard.</p>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5">

            <div class="overflow-x-auto bg-white ">
                <div class="flex justify-start space-x-2 my-3 mx-3">
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap my-2 py-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if (Auth::user()->roles == 'OWNER')
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">
                                        @if (Cache::has('user-is-online-' . $user->id))
                                            <span class="text-green-600">Online</span>
                                        @else
                                            <span class="text-gray-600">Offline</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        @elseif (Auth::user()->roles == 'ADMIN')
                            @foreach ($users as $user)
                                @if ($user->roles !== 'OWNER')
                                    <tr>
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $user->name }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">
                                            @if (Cache::has('user-is-online-' . $user->id))
                                                <span class="text-green-600">Online</span>
                                            @else
                                                <span class="text-gray-600">Offline</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif


                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="container mx-auto mt-5">
            <div class="flex justify-center">
                <div class="w-11/12 md:w-8/12 lg:w-7/12 xl:w-6/12">
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow">
                        <div
                            class="bg-gray-100 dark:bg-gray-900 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold">Users</h2>
                        </div>
                        <div class="p-4">
                            @php $users = DB::table('users')->get(); @endphp
                            <div class="container">
                                <table class="w-full border border-gray-200 dark:border-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-900">
                                        <tr>
                                            <th class="px-4 py-2">Name</th>
                                            <th class="px-4 py-2">Email</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Last Seen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="px-4 py-2">{{ $user->name }}</td>
                                                <td class="px-4 py-2">{{ $user->email }}</td>
                                                <td class="px-4 py-2">
                                                    @if (Cache::has('user-is-online-' . $user->id))
                                                        <span class="text-green-600 dark:text-green-400">Online</span>
                                                    @else
                                                        <span class="text-gray-600 dark:text-gray-400">Offline</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">
                                                    {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
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
        </div> --}}


        <br>

        <!-- Charts -->
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Charts
        </h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Users
                </h4>
                <div style="height: 300px;">
                    {!! $userRegistrationChart->container() !!}
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Transactions
                </h4>
                <div style="height: 300px;">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Data Penjualan Produk Terbanyak
                </h4>
                <div style="height: 300px;">
                    {!! $productChart->container() !!}
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Data Penjualan Produk Per-Bulan
                </h4>
                <div style="height: 300px;">
                    {!! $transactionPriceChart->container() !!}
                </div>
            </div>
        </div>

    </x-slot>

    @push('javascript')
        {{-- <script src="{{ url('https://cdn.jsdelivr.net/npm/chart.js') }}"></script> --}}
        {{-- <script src="{{ asset('chartJS_4-3-0/package/dist/chart.umd.js') }}"></script> --}}
        <script>
            const labels = @json($labels);
            const successData = @json($successData);
            const pendingData = @json($pendingData);
            const canceledData = @json($canceledData);

            const ctx = document.getElementById('transactionChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Success',
                            data: successData,
                            backgroundColor: '#28a745',
                        },
                        {
                            label: 'Pending',
                            data: pendingData,
                            backgroundColor: '#ffc107',
                        },
                        {
                            label: 'Cancelled',
                            data: canceledData,
                            backgroundColor: '#dc3545',
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                },
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#crudTable').DataTable();
            });
        </script>
    @endpush
</x-layout.apps>
