@props([
    'href' => '#',
    'variant' => 'default', // default, primary, success, danger, warning
])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-gray-900 focus:ring-gray-300',
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 hover:text-white focus:ring-blue-500',
    'indigo' => 'bg-indigo-600 text-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500',
    'emerald' => 'bg-emerald-600 text-white hover:bg-emerald-700 hover:text-white focus:ring-emerald-500',
    'success' => 'bg-green-600 text-white hover:bg-green-700 hover:text-white focus:ring-green-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 hover:text-white focus:ring-red-500',
    'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 hover:text-white focus:ring-yellow-500',
];

$variantClasses = $variants[$variant] ?? $variants['default'];
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out ' . $variantClasses
    ]) }}>
    {{ $slot }}
</a>

{{-- 
usage example:
 
<x-link :href="route('job-categories.edit', $category->id)" variant="primary">
    🖋️Edit
</x-link>
 --}}