<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="flex justify-end items-center mb-4">
                <!-- Archived Categories -->
                @if(!$archived)
                    <x-link :href="route('job-categories.index', ['archived' => true])" variant="default" class="mr-3">
                        {{ __('🗃️ Archived Categories') }}
                    </x-link>
                @else
                    <x-link :href="route('job-categories.index')" variant="emerald" class="mr-3">
                        {{ __('🟩 Active Categories') }}
                    </x-link>
                @endif

                <!-- // Button to create a new job category -->
                <x-link :href="route('job-categories.create')" variant="primary">
                    {{ __('➕ Create New Category') }}
                </x-link>


            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        @if($archived)
                            Archived Job Categories
                        @else
                            Active Job Categories
                        @endif
                    </h3>


                    @if ($jobCategories->count() > 0)
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b text-left">#</th>
                                    <th class="px-4 py-2 border-b text-left">Name</th>
                                    <th class="px-4 py-2 border-b text-left">Created At</th>
                                    <th class="px-4 py-2 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobCategories as $index => $category)
                                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-4 py-2 border-b">
                                            {{ $loop->iteration + ($jobCategories->currentPage() - 1) * $jobCategories->perPage() }}
                                        </td>
                                        <td class="px-4 py-2 border-b font-medium text-gray-800">
                                            {{ $category->name }}
                                        </td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            {{ $category->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            <div class="flex space-x-5">
                                                @if(!$archived)
                                                    <x-link :href="route('job-categories.edit', $category->id)" variant="primary">
                                                        ✏️ Edit
                                                    </x-link>
                                                    <form action="{{ route('job-categories.destroy', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button type="submit" variant="default">
                                                            🗑️ Archive
                                                        </x-button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('job-categories.restore', $category->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <x-button type="submit" variant="success">
                                                            ♻️ Restore
                                                        </x-button>
                                                    </form>

                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    @else
                        @if($archived)
                            <p class="text-gray-600">No archived job categories found.</p>
                        @else
                            <p class="text-gray-600">No job categories found.</p>
                        @endif
                    @endif


                </div>
            </div>
            <!-- Pagination links -->
            <div class="mt-4">
                {{ $jobCategories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>