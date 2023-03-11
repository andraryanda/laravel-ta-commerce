@props(['active'])

@php
$classes = ($active ?? false)
            // ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            ? 'inline-flex items-center w-full text-sm font-semibold text-white bg-purple-500 px-2 py-2 rounded transition-colors duration-150 hover:text-white hover:bg-purple-700 dark:hover:text-gray-200 dark:text-gray-100'
            : 'inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200';
@endphp
@php
$classes2 = ($active ?? false)
            ? 'absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg'
            : '';
@endphp

<span {{ $attributes->merge(['class' => $classes2]) }} aria-hidden="true">
</span>
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
