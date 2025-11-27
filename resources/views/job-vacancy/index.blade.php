<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end items-center mb-4">

                @if(!$archived)
                    <x-link :href="route('job-vacancies.index', ['archived' => true])" variant="default" class="mr-3">
                        {{ __('🗃️ Archived Job Vacancies') }}
                    </x-link>
                @else
                    <x-link :href="route('job-vacancies.index')" variant="emerald" class="mr-3">
                        {{ __('🟩 Active Job Vacancies') }}
                    </x-link>
                @endif

                <x-link :href="route('job-vacancies.create')" variant="primary">
                    {{ __('➕ Create New Job Vacancy') }}
                </x-link>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        @if($archived)
                            {{ __("Archived Job Vacancies") }}
                        @else
                            {{ __("Active Job Vacancies") }}
                        @endif
                    </h3>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Salary</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($jobVacancies as $jobVacancy)

                                @php
                                    $rowClickable = !$archived;
                                    $onClick = $rowClickable
                                        ? "onclick=\"window.location.href='" . route('job-vacancies.show', $jobVacancy) . "'\""
                                        : "";
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobVacancy->title }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobVacancy?->company?->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobVacancy->location }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobVacancy->type }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        ${{ $jobVacancy->salary }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">

                                        @if(!$archived)
                                            <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" variant="default">
                                                    🗑️ Archive
                                                </x-button>
                                            </form>
                                        @else
                                            <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="POST"
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
                {{ $jobVacancies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>