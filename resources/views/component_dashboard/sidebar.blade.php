<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        @if (Auth::user()->roles == 'ADMIN')
            <a class="ml-6 flex items-center text-lg font-bold text-gray-800 dark:text-gray-200"
                href="{{ route('dashboard.index') }}">
                <img src="{{ asset('icon/store.png') }}" alt="Al's Store" width="50" class="mr-2"> {{ __('Store') }}
            </a>

            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.index') }}" :active="request()->routeIs('dashboard.index')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Halaman Utama') }}</span>
                    </x-jet-nav-link>
                </li>
            </ul>
        @elseif (Auth::user()->roles == 'USER')
            <a class="ml-6 flex items-center text-lg font-bold text-gray-800 dark:text-gray-200"
                href="{{ route('dashboard.indexDashboardCustomer') }}">
                <img src="{{ asset('icon/store.png') }}" alt="Al's Store" width="50" class="mr-2">
                {{ __('Store') }}
            </a>

            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.indexDashboardCustomer') }}" :active="request()->routeIs('dashboard.indexDashboardCustomer')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Halaman Utama') }}</span>
                    </x-jet-nav-link>
                </li>
            </ul>
        @endif


        <ul>

            @if (Auth::user()->roles == 'ADMIN')
                <li class="relative px-6 py-3">
                    @if (request()->routeis('dashboard.user*'))
                        <button onclick="showMenu1(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                    </path>
                                </svg>
                                <span class="ml-4">User</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon1" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu1"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.index') }}" :active="request()->routeIs('dashboard.user.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserAdmin') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserAdmin*')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Admin') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserCustomer') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserCustomer')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Customer') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu1(true)" {{-- class="inline-flex items-center  justify-between w-full text-sm font-semibold  px-2 py-2 rounded transition-colors duration-150 hover:text-gray-800  dark:hover:text-gray-200"> --}}
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                    </path>
                                </svg>
                                <span class="ml-4">User</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon1" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu1"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.index') }}" :active="request()->routeIs('dashboard.user.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserAdmin') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserAdmin')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Admin') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserCustomer') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserCustomer')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Customer') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.category.index') }}" :active="request()->routeis('dashboard.category*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path>
                        </svg>
                        <span class="ml-4">{{ __('Kategori Produk') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.product.index') }}" :active="request()->is('dashboard/product*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Produk') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.transaction.index*'))
                        <button onclick="showMenu2(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                    </path>
                                </svg>
                                <span class="ml-4">Transaction</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon2" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu2"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexAllTransaction') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexAllTransaction')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Transaction') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexSuccess') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexSuccess')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Success') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexPending') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexPending')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Pending') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexCancelled') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexCancelled')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Cancelled') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu2(true)" {{-- class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" --}}
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            {{-- class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"> --}}
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                    </path>
                                </svg>
                                <span class="ml-4">Transaksi</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon2" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu2"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexAllTransaction') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexAllTransaction')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Transaction') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexSuccess') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexSuccess')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Success') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexPending') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexPending')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Pending') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexCancelled') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexCancelled')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Cancelled') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>

                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.bulan.*'))
                        <button onclick="showMenu4(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                                <span class="ml-4" style="font-size: 12px;">Pembayaran Wifi/Bulan</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon4" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu4"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.bulan.index') }}" :active="request()->routeis('dashboard.bulan.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-3">{{ __('Pembayaran Per-Bulan') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu4(true)"
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                                <span class="ml-3" style="font-size: 12px;" >Pembayaran Wifi/Bulan</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon4" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu4"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.bulan.index') }}" :active="request()->routeis('dashboard.bulan.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-3">{{ __('Pembayaran Per-Bulan') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>


                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.report.laporanStore') }}" :active="request()->routeis('dashboard.report*')">
                        <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5" aria-hidden="true"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>

                        <span class="ml-4">{{ __('Laporan') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.chart.*'))
                        <button onclick="showMenu3(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5"
                                    aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                <span class="ml-4">Grafik Chart Bisnis</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon3" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu3"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartVirtualBisnis') }}"
                                        :active="request()->routeis('dashboard.chart.chartVirtualBisnis')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Virtual Bisnis') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartUsers') }}"
                                        :active="request()->routeis('dashboard.chart.chartUsers')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartTransactions') }}"
                                        :active="request()->routeis('dashboard.chart.chartTransactions')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Transaksi') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu3(true)"
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5"
                                    aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                <span class="ml-4">Grafik Chart Bisnis</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon3" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu3"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartVirtualBisnis') }}"
                                        :active="request()->routeis('dashboard.chart.chartVirtualBisnis')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Virtual Bisnis') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartUsers') }}"
                                        :active="request()->routeis('dashboard.chart.chartUsers')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartTransactions') }}"
                                        :active="request()->routeis('dashboard.chart.chartTransactions')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Transaksi') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
            @elseif (Auth::user()->roles == 'USER')
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.pricingCustomer.index') }}" :active="request()->routeIs('dashboard.pricingCustomer*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Pricing Produk') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.transactionCustomer.index') }}" :active="request()->routeIs('dashboard.transactionCustomer*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Transaksi') }}</span>
                    </x-jet-nav-link>
                </li>
            @endif

        </ul>
        <div class="px-6 my-6">
            <button onclick="window.location.href='{{ route('landingPage.index') }}'" title="Home Page"
                class="inline-flex items-center justify-between w-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-indigo-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center sm:mr-2 sm:mb-2">

                <div class="flex items-center">
                    <img src="{{ asset('icon/homepage.png') }}" class="mr-2" alt="Home Page" width="25">
                    <p class="inline-block">Home Page</p>
                </div>
            </button>
        </div>
    </div>
</aside>
















<!-- Mobile sidebar -->
<!-- Backdrop -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            {{ __('Als Store') }}
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (request()->routeIs('dashboard.index*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg active"
                        aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold text-white bg-purple-500 px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200 dark:text-gray-100"
                        href="{{ route('dashboard.index') }}">
                    @else
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                            href="{{ route('dashboard.index') }}">
                @endif
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        <ul>
            @if (Auth::user()->roles == 'ADMIN')
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.user.index*'))
                        <button onclick="showMenu11(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                    </path>
                                </svg>
                                <span class="ml-4">User</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon11" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu11"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.index') }}" :active="request()->routeIs('dashboard.user.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserAdmin') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserAdmin')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Admin') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserCustomer') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserCustomer')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Customer') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu11(true)" {{-- class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" --}}
                            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                    </path>
                                </svg>
                                <span class="ml-4">User</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon11" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu11"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.index') }}" :active="request()->routeIs('dashboard.user.index')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserAdmin') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserAdmin')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Admin') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.user.indexUserCustomer') }}"
                                        :active="request()->routeIs('dashboard.user.indexUserCustomer')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Users Customer') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.category.index*'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg active"
                            aria-hidden="true"></span>

                        <a class="inline-flex items-center w-full text-sm font-semibold text-white bg-purple-500 px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200 dark:text-gray-100"
                            href="{{ route('dashboard.category.index') }}">
                        @else
                            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                href="{{ route('dashboard.category.index') }}">
                    @endif
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path>

                    </svg>
                    <span class="ml-4">Category</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.product.index*'))
                        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg active"
                            aria-hidden="true"></span>

                        <a class="inline-flex items-center w-full text-sm font-semibold text-white bg-purple-500 px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200 dark:text-gray-100"
                            href="{{ route('dashboard.product.index') }}">
                        @else
                            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                href="{{ route('dashboard.product.index') }}">
                    @endif
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9">
                        </path>
                    </svg>
                    <span class="ml-4">Product</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.transaction.index*'))
                        <button onclick="showMenu12(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                    </path>
                                </svg>
                                <span class="ml-4">Transaction</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon12" class="transform" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu12"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexAllTransaction') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexAllTransaction')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Transaction') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexSuccess') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexSuccess')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Success') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexPending') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexPending')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Pending') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexCancelled') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexCancelled')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Cancelled') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu12(true)" {{-- class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" --}}
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                    </path>
                                </svg>
                                <span class="ml-4">Transaction</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon12" class="transform" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu12"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexAllTransaction') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexAllTransaction')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('All Transaction') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexSuccess') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexSuccess')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Success') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexPending') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexPending')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Pending') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.transaction.indexCancelled') }}"
                                        :active="request()->routeIs('dashboard.transaction.indexCancelled')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Cancelled') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.report.laporanStore') }}" :active="request()->routeis('dashboard.report*')">
                        <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5" aria-hidden="true"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>

                        <span class="ml-4">{{ __('Laporan') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    @if (request()->routeIs('dashboard.chart.*'))
                        <button onclick="showMenu13(true)"
                            class="inline-flex items-center justify-between w-full text-sm font-semibold bg-purple-500 text-white px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5"
                                    aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                <span class="ml-4">Grafik Chart Bisnis</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon13" class="transform" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu13"
                            class="flex justify-start my-2.5 flex-col w-full md:w-auto items-start pb-1 ">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartVirtualBisnis') }}"
                                        :active="request()->routeis('dashboard.chart.chartVirtualBisnis')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Virtual Bisnis') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartUsers') }}"
                                        :active="request()->routeis('dashboard.chart.chartUsers')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartTransactions') }}"
                                        :active="request()->routeis('dashboard.chart.chartTransactions')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Transaksi') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @else
                        <button onclick="showMenu13(true)"
                            class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="{{ url('http://www.w3.org/2000/svg') }}" class="w-5 h-5"
                                    aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                <span class="ml-4">Grafik Chart Bisnis</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                id="icon13" class="transform" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </path>
                            </svg>
                        </button>
                        <div id="menu13"
                            class="flex justify-start flex-col w-full md:w-auto items-start pb-1 hidden">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                class="p-2 mt-2 space-y-2 overflow-hidden w-full text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartVirtualBisnis') }}"
                                        :active="request()->routeis('dashboard.chart.chartVirtualBisnis')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Virtual Bisnis') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartUsers') }}"
                                        :active="request()->routeis('dashboard.chart.chartUsers')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Users') }}</span>
                                    </x-jet-nav-link>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
                                    <x-jet-nav-link href="{{ route('dashboard.chart.chartTransactions') }}"
                                        :active="request()->routeis('dashboard.chart.chartTransactions')">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z">
                                            </path>
                                        </svg>
                                        <span class="ml-4">{{ __('Grafik Tahun Transaksi') }}</span>
                                    </x-jet-nav-link>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
            @elseif (Auth::user()->roles == 'USER')
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.pricingCustomer.index') }}" :active="request()->routeIs('dashboard.pricingCustomer*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Pricing Produk') }}</span>
                    </x-jet-nav-link>
                </li>
                <li class="relative px-6 py-3">
                    <x-jet-nav-link href="{{ route('dashboard.transactionCustomer.index') }}" :active="request()->routeIs('dashboard.transactionCustomer*')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                            </path>
                        </svg>
                        <span class="ml-4">{{ __('Transaksi') }}</span>
                    </x-jet-nav-link>
                </li>
            @endif
        </ul>

        <div class="px-6 my-6">
            <button onclick="window.location.href='{{ route('landingPage.index') }}'" title="Home Page"
                class="inline-flex items-center justify-between w-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-indigo-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center sm:mr-2 sm:mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('icon/homepage.png') }}" class="mr-2" alt="Home Page" width="25">
                    <p class="inline-block">Home Page</p>
                </div>
            </button>
        </div>
    </div>
</aside>
