<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            @if (request()->has('q'))
                Hasil pencarian untuk "{{ request('q') }}"
            @else
                {{ __('Halaman Produk') }}
            @endif
        </h2>
    </x-slot>


    @section('transactionCustomer')
        @push('javascript')
        @endpush

        @if (request()->has('q'))
            <a href="{{ route('dashboard.pricingCustomer.index') }}"
                class="w-24 my-1.5 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                    <p class="inline-block">Back</p>
                </div>
            </a>
        @endif
        <div class="flex justify-center mb-5">
            <form action="{{ route('dashboard.pricingCustomer.searchProductDashboardCustomer') }}" method="GET"
                class="w-full max-w-sm">
                <div class="relative text-gray-600 focus-within:text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                <path d="M21 21l-4.35-4.35"></path>
                                <path d="M15 11a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>
                    </span>
                    <input type="search" name="q"
                        class="w-full py-2 pl-10 text-sm text-gray-900 bg-white rounded-md focus:outline-none focus:bg-white focus:text-gray-900"
                        placeholder="Search..." autocomplete="off">
                </div>
            </form>
        </div>

        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center">
                @forelse ($products as $product)
                    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
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
                    <div class="flex justify-center">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">No products available.</strong>
                            <span class="block sm:inline">Please try a different search term.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{ $products->links() }}
    @endsection

</x-layout.apps>
