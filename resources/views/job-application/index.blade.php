<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end items-center mb-4">

                @if(!$archived)
                    <x-link :href="route('job-applications.index', ['archived' => true])" variant="default" class="mr-3">
                        {{ __('🗃️ Archived Job Applications') }}
                    </x-link>
                @else
                    <x-link :href="route('job-applications.index')" variant="emerald" class="mr-3">
                        {{ __('🟩 Active Job Applications') }}
                    </x-link>
                @endif

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        @if($archived)
                            {{ __("Archived Job Applications") }}
                        @else
                            {{ __("Active Job Applications") }}
                        @endif
                    </h3>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Applicant Name
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position (Job Vacancy)
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($jobApplications as $jobApplication)

                                @php
                                    $rowClickable = !$archived;
                                    $onClick = $rowClickable
                                        ? "onclick=\"window.location.href='" . route('job-applications.show', $jobApplication) . "'\""
                                        : "";
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobApplication?->user?->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobApplication?->jobVacancy?->title ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        {{ $jobApplication?->jobVacancy?->company?->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $rowClickable ? 'cursor-pointer' : '' }}"
                                        {!! $onClick !!}>
                                        <x-status-badge :status="$jobApplication->status" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">

                                        @if(!$archived)
                                            <form action="{{ route('job-applications.destroy', $jobApplication->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" variant="default">
                                                    🗑️ Archive
                                                </x-button>
                                            </form>
                                        @else
                                            <form action="{{ route('job-applications.restore', $jobApplication->id) }}"
                                                method="POST" class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('PUT')
                                                <x-button type="submit" variant="success">
                                                    ♻️ Restore
                                                </x-button>
                                            </form>
                                        @endif

                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No job applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>



                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $jobApplications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>