<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Transaksi Chart') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <form action="{{ route('dashboard.chart.chartUsers') }}" method="GET" class="form-inline mb-3">
            <div class="flex justify-start items-center mb-4">
                <label for="year" class="mr-2 flex items-center font-medium text-gray-600">
                    Tahun:
                </label>
                <div class="relative">
                    <select name="year" id="year"
                        class="form-select  block w-full pr-10 py-2 text-base leading-6 font-medium text-gray-700 bg-white border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        onchange="this.form.submit()">
                        <option disabled>-- Pilih Tahun --</option>
                        @foreach ($availableYears as $availableYear)
                            <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                                {{ $availableYear }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </form>

        <div class="bg-white rounded-lg shadow-md p-4">
            {!! $chart->container() !!}
        </div>
    </x-slot>

    <x-slot name="script">
        {!! $chart->script() !!}
    </x-slot>
    </x-layout>
