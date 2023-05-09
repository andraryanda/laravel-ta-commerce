<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Pembayaran Perbulan Wifi') }}
        </h2>
    </x-slot>

    @push('javascript')
    @endpush


    @section('pembayaran_bulan_wifi')
        <h1><b>Testing Bulan Wifi</b></h1>
    @endsection
</x-layout.apps>
