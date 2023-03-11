<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Transaction Cancelled') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <x-slot name="script">
            <script>
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#crudTable tfoot th:not(:last-child)').each(function() {
                        var title = $(this).text();
                        $(this).html('<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left " placeholder="Search ..." ' + title + '" />');
                    });

                    // DataTable
                    var table = $('#crudTable').DataTable({
                        initComplete: function() {
                            // Apply the search
                            this.api()
                                .columns(':not(:last-child)')
                                .every(function() {
                                    var that = this;

                                    $('input', this.footer()).on('keyup change clear', function() {
                                        if (that.search() !== this.value) {
                                            that.search(this.value).draw();
                                        }
                                    });
                                });
                        },
                        // responsive: true,
                        // searching: true,
                        // ordering: true,
                        processing: true,
                        // serverSide: true,
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'id',
                                name: 'id',
                                width: '5%',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'user.name',
                                name: 'user.name',

                            },
                            {
                                data: 'total_price',
                                name: 'total_price',
                                className: 'dt-body-start',
                                render: $.fn.dataTable.render.number('.', ',', 2, 'Rp '),
                            },
                            {
                                data: 'status',
                                name: 'status',
                                className: 'dt-body-start',

                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                width: '25%',
                            },
                        ],
                        pagingType: 'full_numbers',
                        order: [
                            [0, 'desc'] // Kolom indeks 0 diurutkan secara descending
                        ],
                        language: {
                            searchPlaceholder: "Search Data Transaction",
                            decimal: ',',
                            thousands: '.',
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Prev",
                            },
                        }
                    });
                });
            </script>
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
                    if (typeof value === 'string' && value.includes('$')) {
                        value = this.numericCurrency(value);
                    }

                    // if 0, manually convert to currency. otherwise !Number is falsy and returns unformatted 0
                    if (value == 0) return '$0';

                    // preserve string and exit, no need for currency conversion
                    if (!Number(value)) return value;

                    return Number(value).toLocaleString('id-ID', {
                        //   return Number(value).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
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
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="px-3 py-3 overflow-x-auto bg-white sm:p-6">
            <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                </tbody>
                <tfoot>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    </x-slot>
</x-layout.apps>
