@if ($errors->any())
    <div {{ $attributes }} class="bg-red-100 rounded-md shadow-md">
        <div class="bg-red-400 text-white px-4 py-3">
            <div class="flex items-center">
                <div class="mr-2">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
                <div>
                    <strong class="font-medium">{{ __('Whoops! Something went wrong.') }}</strong>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 bg-red-50">
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
