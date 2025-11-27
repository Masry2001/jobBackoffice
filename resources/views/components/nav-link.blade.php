@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center w-full px-4 py-3 rounded-lg bg-indigo-100 text-indigo-700 font-medium transition-all duration-150 ease-in-out'
        : 'flex items-center w-full px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-indigo-600 transition-all duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>