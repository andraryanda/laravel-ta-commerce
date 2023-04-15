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
            Transaction &raquo; {{ $item->name }} &raquo; Edit
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('transaction')

        <x-slot name="script">
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </x-slot>

        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
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
                    <form class="w-full" action="{{ route('dashboard.transaction.update', encrypt($item->id)) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Status
                                </label>
                                <select name="status"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name">
                                    <option value="{{ $item->status }}">{{ $item->status }}</option>
                                    <option disabled>-------</option>
                                    <option value="PENDING">PENDING</option>
                                    <option value="SUCCESS">SUCCESS</option>
                                    <option value="CANCELLED">CANCELLED</option>
                                    <option value="FAILED">FAILED</option>
                                    <option value="SHIPPING">SHIPPING</option>
                                    <option value="SHIPPED">SHIPPED</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">
                                    <div class="flex items-center">
                                        <img src="{{ asset('icon/save.png') }}" alt="save" class="mr-2" width="20"
                                            height="20">
                                        <p>Simpan Update Transaction</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ url('https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replace('description');
        </script>
    @endsection

</x-layout.apps>
