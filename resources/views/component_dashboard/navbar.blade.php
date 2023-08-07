<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        <div class="">
            {{-- <button onclick="window.location.href='{{ route('landingPage.index') }}'" title="Home Page"
                class="w-full sm:w-auto text-white bg-gradient-to-r from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-indigo-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center sm:mr-2 sm:mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('icon/homepage.png') }}" class="mr-2" alt="Home Page" width="25">
                    <p class="inline-block">Home Page</p>
                </div>
            </button> --}}
        </div>


        {{-- <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search for projects" aria-label="Search" />
            </div>
        </div> --}}
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Theme toggler -->
            {{-- <li class="flex">
                <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme"
                    aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                            </path>
                        </svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </template>
                </button>
            </li> --}}
            <!-- Notifications menu -->
            @if (Auth::user()->roles == 'OWNER' || Auth::user()->roles == 'ADMIN')

                <li class="relative">
                    <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
                        @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                        aria-label="Notifications" aria-haspopup="true">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                        <!-- Notification badge -->
                        @php
                            $notificationCount = app(\App\Http\Controllers\NotificationTransactionController::class)->getCount();
                        @endphp
                        @if ($notificationCount > 0)
                            <span aria-hidden="true"
                                class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
                        @endif
                    </button>
                    <template x-if="isNotificationsMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
                            @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 "
                            aria-label="submenu">
                            <li class="rounded-md shadow-md bg-white dark:bg-gray-800 overflow-hidden">
                                <div
                                    class="flex justify-between items-center text-lg font-bold px-4 py-3 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <div>Notifikasi</div>
                                    <div>
                                        <svg class="w-6 h-6 text-red-800 dark:text-white cursor-pointer"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 18 20" onclick="confirmDelete()">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                        </svg>
                                    </div>
                                </div>

                                <ul class="divide-y divide-gray-200">
                                    {{-- <li class="px-4 py-3">
                                        <div class="flex justify-between">
                                            <span class="font-semibold">New Order</span>
                                            <button type="button" class="text-gray-500 hover:text-red-500">
                                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10 8.586L6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 001.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293a1 1 0 00-1.414-1.414L10 8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">

                                            @foreach ($notification as $notif)
                                                {{ $notif->id }}
                                            @endforeach
                                        </p>
                                    </li> --}}
                                    @php
                                        $notifications = App\Models\NotificationTransaction::with(['transaction'])
                                            ->whereHas('transaction', function ($query) {
                                                $query->whereNotNull('id')->whereNull('deleted_at');
                                            })
                                            ->get();
                                    @endphp

                                    <li>
                                        @foreach ($notifications->take(5) as $notif)
                                            @php
                                                $deleteRoute = route('dashboard.notif-transaction.destroy', $notif->id);
                                            @endphp

                                            <hr>
                                            <div x-data="{ isHovered: false }"
                                                onclick="window.location.href='{{ route('dashboard.transaction.show', Crypt::encrypt($notif->transaction->id)) }}'">
                                                <div class="px-4 py-3 cursor-pointer transition duration-300 ease-in-out transform hover:bg-gray-100 dark:hover:bg-gray-800"
                                                    x-bind:class="{ 'bg-gray-100 dark:bg-gray-800': isHovered }"
                                                    @mouseenter="isHovered = true" @mouseleave="isHovered = false"
                                                    x-on:click="showProductDetails('{{ $notif->transaction->items[0]->product->name ?? '' }}')">
                                                    <div class="flex justify-between">
                                                        <span class="font-semibold">Transaksi Baru
                                                            - {{ $loop->iteration }}</span>
                                                        <form action="{{ $deleteRoute }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="text-gray-500 hover:text-red-500">
                                                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M10 8.586L6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 001.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293a1 1 0 00-1.414-1.414L10 8.586z" />
                                                                </svg>
                                                            </button>
                                                        </form>

                                                    </div>

                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                        {{ $notif->transaction->user->name ?? 'Data Dihapus' }}
                                                    </span>

                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">
                                                        {{ $notif->transaction->items[0]->product->name ?? 'Not Found' }}
                                                    </p>

                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">
                                                        @if ($notif->transaction->status == 'SUCCESS')
                                                            <span
                                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                                {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                            </span>
                                                        @elseif ($notif->transaction->status == 'PENDING')
                                                            <span
                                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                                                {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                            </span>
                                                        @elseif ($notif->transaction->status == 'CANCELLED')
                                                            <span
                                                                class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                            </span>
                                                        @endif
                                                        {{ isset($notif->transaction->items[0]->product->price) ? number_format($notif->transaction->items[0]->product->price, 0, ',', '.') : 'Not Found' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach

                                        <hr>
                                        <div class="my-3 text-center">
                                            <a href="{{ route('dashboard.transaction.indexPending') }}"
                                                class="text-blue-700 hover:underline font-bold">
                                                Tampilkan Semua Pesan
                                            </a>
                                        </div>
                                    </li>



                                </ul>
                            </li>
                        </ul>
                    </template>

                </li>
            @elseif (Auth::user()->roles == 'USER')
                <li class="relative">
                    <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
                        @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                        aria-label="Notifications" aria-haspopup="true">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                        <!-- Notification badge -->
                        @php
                            $notificationCount = app(\App\Http\Controllers\NotificationTransactionController::class)->getCount();
                        @endphp
                        @if ($notificationCount > 0)
                            <span aria-hidden="true"
                                class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
                        @endif
                    </button>
                    <template x-if="isNotificationsMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
                            @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 "
                            aria-label="submenu">
                            <li class="rounded-md shadow-md bg-white dark:bg-gray-800 overflow-hidden">
                                <div
                                    class="flex justify-between items-center text-lg font-bold px-4 py-3 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <div>Notifikasi</div>
                                    {{-- <div>
                                        <svg class="w-6 h-6 text-red-800 dark:text-white cursor-pointer"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 18 20" onclick="confirmDelete()">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                        </svg>
                                    </div> --}}
                                </div>

                                <ul class="divide-y divide-gray-200">
                                    @php
                                        $notifications = App\Models\NotificationTransaction::with(['transaction'])
                                            ->whereHas('transaction', function ($query) {
                                                $query->whereNotNull('id')->whereNull('deleted_at');
                                            })
                                            ->get();
                                    @endphp

                                    <li>
                                        @foreach ($notifications->take(5) as $notif)
                                            @if ($notif->transaction->users_id == Auth::user()->id)
                                                @php
                                                    $deleteRoute = route('dashboard.notif-transaction.destroy', $notif->id);
                                                @endphp

                                                <hr>
                                                <div x-data="{ isHovered: false }"
                                                    onclick="window.location.href='{{ route('dashboard.transaction.show', Crypt::encrypt($notif->transaction->id)) }}'">
                                                    <div class="px-4 py-3 cursor-pointer transition duration-300 ease-in-out transform hover:bg-gray-100 dark:hover:bg-gray-800"
                                                        x-bind:class="{ 'bg-gray-100 dark:bg-gray-800': isHovered }"
                                                        @mouseenter="isHovered = true" @mouseleave="isHovered = false"
                                                        x-on:click="showProductDetails('{{ $notif->transaction->items[0]->product->name ?? '' }}')">
                                                        <div class="flex justify-between">
                                                            <span class="font-semibold">Transaksi Baru
                                                                - {{ $loop->iteration }}</span>
                                                            <form action="{{ $deleteRoute }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="text-gray-500 hover:text-red-500">
                                                                    <svg class="h-5 w-5 fill-current"
                                                                        viewBox="0 0 20 20"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M10 8.586L6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 001.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293a1 1 0 00-1.414-1.414L10 8.586z" />
                                                                    </svg>
                                                                </button>
                                                            </form>

                                                        </div>

                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                            {{ $notif->transaction->user->name ?? 'Data Dihapus' }}
                                                        </span>

                                                        <p
                                                            class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">
                                                            {{ $notif->transaction->items[0]->product->name ?? 'Not Found' }}
                                                        </p>

                                                        <p
                                                            class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-bold">
                                                            @if ($notif->transaction->status == 'SUCCESS')
                                                                <span
                                                                    class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                                    {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                                </span>
                                                            @elseif ($notif->transaction->status == 'PENDING')
                                                                <span
                                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                                                    {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                                </span>
                                                            @elseif ($notif->transaction->status == 'CANCELLED')
                                                                <span
                                                                    class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                    {{ $notif->transaction->status ?? 'Data Dihapus' }}
                                                                </span>
                                                            @endif
                                                            {{ isset($notif->transaction->items[0]->product->price) ? number_format($notif->transaction->items[0]->product->price, 0, ',', '.') : 'Not Found' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <hr>
                                        <div class="my-3 text-center">
                                            <a href="{{ route('dashboard.transaction.indexPending') }}"
                                                class="text-blue-700 hover:underline font-bold">
                                                Tampilkan Semua Pesan
                                            </a>
                                        </div>
                                    </li>



                                </ul>
                            </li>
                        </ul>
                    </template>

                </li>
            @endif
            {{-- You have a new order from John Doe --}}

            <!-- Profile menu -->
            <li class="relative">
                {{-- <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                    @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                    aria-haspopup="true">
                    <img class="object-cover w-8 h-8 rounded-full"
                        src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82"
                        alt="" aria-hidden="true" />
                </button> --}}
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <button
                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </button>
                @else
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-white hover:bg-purple-400 focus:outline-none transition ease-in-out duration-150 "
                            @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                            aria-haspopup="true">
                            {{ Auth::user()->name }}

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                @endif
                <template x-if="isProfileMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
                        @keydown.escape="closeProfileMenu"
                        class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        aria-label="submenu">
                        <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                href="{{ route('dashboard.profileUser.index') }}">
                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                <span>Profile</span>
                            </a>
                        </li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li class="flex">
                                <!-- Authentication -->
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-red-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                   this.closest('form').submit();">
                                    <svg class="w-4 h-4 mr-3 text-red-500" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span class="text-red-400">Log out</span>
                                </a>
                            </li>
                        </form>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>

@push('javascript')
    <script>
        function confirmDelete() {
            if (confirm("Apakah Anda yakin ingin menghapus semua data notifikasi ini?")) {
                // Jika pengguna mengonfirmasi, lakukan permintaan POST ke rute penghapusan
                fetch("{{ route('dashboard.notifications.destroy-all') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        // Lakukan tindakan setelah penghapusan berhasil, misalnya muat ulang halaman
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
@endpush
