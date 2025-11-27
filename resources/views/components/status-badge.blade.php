@props([
    'status' => '',
])

@php
    $statusColors = [
        'Accepted' => 'text-green-600 font-semibold',
        'Rejected' => 'text-red-600 font-semibold',
        'Pending' => 'text-yellow-600 font-semibold',
    ];
    $statusClass = $statusColors[$status] ?? 'text-gray-900';
@endphp

<span {{ $attributes->merge([
    'class' => 'px-3 py-1 rounded-md ' . $statusClass
]) }}>
    {{ $status }}
</span>
