@props([
'type' => 'button',
'variant' => 'default', // default, primary, success, danger, warning, secondary
])

@php
$variants = [
'default' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-gray-900 focus:ring-gray-300',
'primary' => 'bg-blue-600 text-white hover:bg-blue-700 hover:text-white focus:ring-blue-500',
'success' => 'bg-green-600 text-white hover:bg-green-700 hover:text-white focus:ring-green-500',
'danger' => 'bg-red-600 text-white hover:bg-red-700 hover:text-white focus:ring-red-500',
'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 hover:text-white focus:ring-yellow-500',
'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 hover:text-white focus:ring-gray-500',
];

$variantClasses = $variants[$variant] ?? $variants['default'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge([
  'class' => 'inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-md focus:outline-none
  focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed '
  . $variantClasses
  ]) }}>
  {{ $slot }}
</button>


{{--
useage examples:

<x-button type="submit" variant="primary">
  💾 Save Changes
</x-button>


<x-button type="button" variant="danger">
  🗑️ Delete
</x-button>


<x-button type="button" variant="default">
  ❌ Cancel
</x-button>


<x-button variant="primary" disabled>
  Loading...
</x-button>


<x-button variant="success" class="w-full">
  ✅ Confirm
</x-button>


<x-button variant="warning" @click="showModal = true">
  ⚠️ Warning
</x-button>

--}}