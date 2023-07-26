<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan melalui email kepada Anda? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan email yang lain kepada Anda.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </div>
        @endif

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Jika sudah verifikasi Email dan tidak berpindah halaman secara otomatis, maka silahkan klik tombol Dashboard. Apabila tidak bisa login/memasuki halaman Dashboard, silahkan melakukan login 2x dan jika masih tetap tidak bisa silahkan menghubungi Admin. Whatsapp: 085314005779') }}
        </div>
        @if (Auth::user()->roles == 'ADMIN')
            <x-jet-button type="button" onclick="window.location.href='{{ route('dashboard.indexDashboardCustomer') }}'">
                {{ __('Dashboard') }}
            </x-jet-button>
        @elseif (Auth::user()->roles == 'USER')
            <x-jet-button type="button" onclick="window.location.href='{{ route('dashboard.indexDashboardCustomer') }}'">
                {{ __('Dashboard') }}
            </x-jet-button>
        @else
            <x-jet-button type="button" onclick="window.location.href='{{ route('landingPage.index') }}'">
                {{ __('Dashboard') }}
            </x-jet-button>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Kirim Ulang Verification Email') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
