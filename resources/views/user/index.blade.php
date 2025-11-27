<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="flex justify-end items-center mb-4">
                <!-- Archived Users -->
                @if(!$archived)
                    <x-link :href="route('users.index', ['archived' => true])" variant="default" class="mr-3">
                        {{ __('🗃️ Archived Users') }}
                    </x-link>
                @else
                    <x-link :href="route('users.index')" variant="emerald" class="mr-3">
                        {{ __('🟩 Active Users') }}
                    </x-link>
                @endif

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        @if($archived)
                            Archived Users
                        @else
                            Active Users
                        @endif
                    </h3>


                    @if ($users->count() > 0)
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b text-left">#</th>
                                    <th class="px-4 py-2 border-b text-left">Name</th>
                                    <th class="px-4 py-2 border-b text-left">Email</th>
                                    <th class="px-4 py-2 border-b text-left">Role</th>
                                    <th class="px-4 py-2 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-4 py-2 border-b">
                                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                        </td>
                                        <td class="px-4 py-2 border-b font-medium text-gray-800">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-2 border-b text-gray-600">
                                            {{ $user->role }}
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            <div class="flex space-x-5">
                                                @if($user->role !== 'Admin')
                                                    @if(!$archived)
                                                        <x-link :href="route('users.edit', $user->id)" variant="primary">
                                                            ✏️ Edit
                                                        </x-link>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-button type="submit" variant="default">
                                                                🗑️ Archive
                                                            </x-button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <x-button type="submit" variant="success">
                                                                ♻️ Restore
                                                            </x-button>
                                                        </form>

                                                    @endif
                                                @else
                                                    <span class="text-gray-500 text-sm">No actions available</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    @else
                        @if($archived)
                            <p class="text-gray-600">No archived users found.</p>
                        @else
                            <p class="text-gray-600">No users found.</p>
                        @endif
                    @endif


                </div>
            </div>
            <!-- Pagination links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>