<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Notification Transaksi') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('notification')
        <x-slot name="styles">

        </x-slot>

        <x-slot name="script">

        </x-slot>

        <h1>Notification Transaksi</h1>



        @push('javascript')
            <script>
                $('body').on('click', '.delete-button', function() {
                    var category_id = $(this).data("id");
                    Swal.fire({
                        title: 'Apakah anda yakin ingin menghapus category ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('dashboard.category.destroy', ':id') }}".replace(
                                    ':id', category_id),
                                data: {
                                    "_token": "{{ csrf_token() }}"
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });
                            setTimeout(function() {
                                    location.reload();
                                },
                                1000
                            ); // memberikan jeda selama 1000 milidetik atau 1 detik sebelum reload
                            let timerInterval;
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your data has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    timerInterval = setInterval(() => {}, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                    location.reload();
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log('I was closed by the timer');
                                }
                            });
                        }
                    });
                });
            </script>
        @endpush
    @endsection

</x-layout.apps>
