<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end items-center mb-4">

                @if(!$archived)
                    <x-link :href="route('companies.index', ['archived' => true])" variant="default" class="mr-3">
                        {{ __('🗃️ Archived Companies') }}
                    </x-link>
                @else
                    <x-link :href="route('companies.index')" variant="emerald" class="mr-3">
                        {{ __('🟩 Active Companies') }}
                    </x-link>
                @endif

                <x-link :href="route('companies.create')" variant="primary">
                    {{ __('➕ Create New Company') }}
                </x-link>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        @if($archived)
                            {{ __("Archived Companies") }}
                        @else
                            {{ __("Active Companies") }}
                        @endif
                    </h3>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Industry</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Website</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($companies as $company)

                                @php
                                    $rowClickable = !$archived;
                                    $onClick = $rowClickable
                                        ? "onclick=\"window.location.href='" . route('companies.show', $company) . "'\""
                                        : "";
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $company->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $company->address }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $company->industry }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                        @if ($company->website)
                                            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                                                onclick="event.stopPropagation()">
                                                {{ $company->website }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">

                                        @if(!$archived)
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" variant="default">
                                                    🗑️ Archive
                                                </x-button>
                                            </form>
                                        @else
                                            <form action="{{ route('companies.restore', $company->id) }}" method="POST"
                                                class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PUT')
                                                <x-button type="submit" variant="success">
                                                    ♻️ Restore
                                                </x-button>
                                            </form>
                                        @endif

                                    </td>

                                </tr>

                            @endforeach
                        </tbody>



                    </table>


                </div>
            </div>

            <div class="mt-4">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>