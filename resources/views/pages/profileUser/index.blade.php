<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Profile User - ') }} {{ $user->name }}
        </h2>
    </x-slot>

    @section('profileUser')
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <form action="{{ route('dashboard.profileUser.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            Name</label>
                        <input type="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Nama" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            email</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            Phone</label>
                        <input type="phone" id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Telephone" name="phone" value="{{ $user->phone }}" required>
                    </div>
                    <div class="mb-6">

                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            Alamat</label>
                        <textarea id="alamat" rows="4" name="alamat"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Alamat..." value="{{ $user->alamat }}">{{ $user->alamat }}</textarea>

                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Update
                        </button>
                    </div>
                    <!-- Tambahkan data lain sesuai kebutuhan -->
                </div>
            </form>
        </div>
    @endsection
</x-layout.apps>
