<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Users Customer') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <x-slot name="script">
            <script>
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#crudTable tfoot th:not(:last-child)').each(function() {
                        var title = $(this).text();
                        $(this).html(
                            '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left " placeholder="Search ..." ' +
                            title + '" />');
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
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'id',
                                name: 'id',
                                width: '5%'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'roles',
                                name: 'roles'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                width: '25%'
                            },
                        ],
                        pagingType: 'full_numbers',
                        order: [
                            [0, 'desc'] // Kolom indeks 0 diurutkan secara descending
                        ],
                        language: {
                            searchPlaceholder: "Search Data Users",
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Prev",
                            },
                        }
                    })
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
                            <th>Email</th>
                            <th>Roles</th>
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
                <div class="mb-10 mt-3">
                    <a href="{{ route('dashboard.product.create') }}"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold mx-2 py-2 px-4 rounded shadow-lg">
                        + Create User
                    </a>
                    <a href="{{ route('dashboard.user.exportRoleUser') }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold mx-2 py-2 px-4 rounded shadow-lg">
                        <i class="fa fa-file"></i> Export User
                    </a>
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>

    </x-slot>
</x-layout.apps>
