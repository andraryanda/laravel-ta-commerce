<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Halaman Produk') }}
        </h2>
    </x-slot>

    @section('transactionCustomer')
        @push('javascript')
        @endpush

        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center">
                @forelse ($products as $product)
                    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                        <div class="bg-white rounded-lg shadow-md">
                            <img src="{{ $product->productGallery->first()->url ?? 'Not Found!' }}"
                                class="w-full h-48 object-cover object-center" alt="{{ $product->name }}">
                            <div class="p-4">
                                <h5 class="text-xl font-semibold mb-2">{{ Str::limit($product->name, 30, '...') }}</h5>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-300 flex justify-between items-center">
                                <h5 class="text-lg font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                                <button
                                    onclick="window.location.href='{{ route('landingPage.checkout.shipping', encrypt($product->id)) }}'"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-full flex items-center">
                                    {{ __('Buy') }}
                                    <svg class="w-5 h-5 ml-2" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full">
                        <p class="text-center">No products available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endsection

</x-layout.apps>
