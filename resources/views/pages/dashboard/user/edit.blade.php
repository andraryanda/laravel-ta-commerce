<x-layout.apps>

    <x-slot name="header">
        <button onclick="goBack()"
            class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
            <div class="flex items-center">
                <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                <p class="inline-block">Back</p>
            </div>
        </button>

        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            User &raquo; {{ $item->name }} &raquo; Edit
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('user')

        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div>
                    @if ($errors->any())
                        <div class="mb-5" role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                There's something wrong!
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                        </div>
                    @endif
                    <form class="w-full" action="{{ route('dashboard.user.update', encrypt($item->id)) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                    for="grid-last-name">
                                    Name
                                </label>
                                <input value="{{ old('name') ?? $item->name }}" name="name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" placeholder="User Name">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                    for="grid-last-name">
                                    Email
                                </label>
                                <input value="{{ old('email') ?? $item->email }}" name="email"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="email" placeholder="User Email">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                    for="grid-last-name">
                                    Username
                                </label>
                                <input value="{{ old('username') ?? $item->username }}" name="username"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" placeholder="Username">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                    for="grid-last-name">
                                    Phone
                                </label>
                                <input value="{{ old('phone') ?? $item->phone }}" name="phone"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" placeholder="Phone">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="alamat"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Tuliskan Alamat..." value="{{ old('alamat') ?? $item->alamat }}" required>{{ $item->alamat }}</textarea>
                        </div>

                        {{-- <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-last-name">
                                Roles
                            </label>
                            <select name="roles"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-last-name">
                                <option value="{{ $item->roles }}">{{ $item->roles }}</option>
                                <option disabled>-------</option>
                                <option value="ADMIN">ADMIN</option>
                                <option value="USER">USER</option>
                            </select>
                        </div>
                    </div> --}}
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                    for="grid-last-name">
                                    Roles
                                </label>
                                <select name="roles" id="roles-select"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="{{ $item->roles }}">{{ $item->roles }}</option>
                                    <option disabled>-------</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="USER">USER</option>
                                </select>
                            </div>
                        </div>


                        <hr class="py-3">
                        <div
                            class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label
                                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-200"
                                        for="grid-last-name">
                                        Password
                                    </label>
                                    <span class="text-red-500">*<i>Jika ingin mengubah Password silahkan
                                            langsung mengisi Form Password. Jika tidak ingin mengganti password Abaikan
                                            form ini.</i></span>
                                    <input value="{{ old('password') }}" name="password"
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-last-password" type="password" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mx-3 mb-6 my-5">
                            <div class="text-right">
                                <button type="reset" id="reset-button"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-right">
                                    Kembali Setelan Awal
                                </button>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 text-right">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right"
                                        onclick="disableButton(this);">
                                        <div class="flex items-center">
                                            <img src="{{ asset('icon/save.png') }}" alt="save" class="mr-2"
                                                width="20" height="20">
                                            <p id="buttonText">Simpan Update User</p>
                                        </div>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('javascript')
        <script>
            function disableButton(button) {
                button.disabled = true;
                var buttonText = document.getElementById("buttonText");
                buttonText.innerText = "Tunggu...";
                button.form.submit();
            }
        </script>


        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <script>
            $(document).ready(function() {
                var resetButton = $('#reset-button');

                // Tampilkan konfirmasi dialog saat button reset diklik
                resetButton.click(function() {
                    var confirmed = confirm("Apakah Anda yakin ingin mengembalikan setelan awal?");
                    if (!confirmed) {
                        return false;
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var rolesSelect = $('#roles-select');
                var currentRole = rolesSelect.val();

                // Nonaktifkan dan sembunyikan opsi "ADMIN" jika nilai roles saat memasuki halaman edit adalah "USER"
                if (currentRole == 'USER') {
                    rolesSelect.find('option[value="ADMIN"]').prop('disabled', true);
                    rolesSelect.find('option[value="ADMIN"]').prop('hidden', true);
                }

                // Tampilkan kembali opsi "ADMIN" jika nilai roles diubah menjadi "ADMIN"
                rolesSelect.change(function() {
                    var selectedRole = $(this).val();
                    rolesSelect.find('option[value="ADMIN"]').prop('disabled', false);
                    rolesSelect.find('option[value="ADMIN"]').prop('hidden', false);
                    if (selectedRole == 'USER') {
                        rolesSelect.find('option[value="ADMIN"]').prop('disabled', true);
                        rolesSelect.find('option[value="ADMIN"]').prop('hidden', true);
                    }
                });
            });
        </script>
    @endpush

</x-layout.apps>
