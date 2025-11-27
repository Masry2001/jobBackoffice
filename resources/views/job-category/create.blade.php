<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create Job Category') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-8 text-gray-900">
          <h3 class="text-lg font-semibold mb-6">
            {{ __("Create a new job category") }}
          </h3>

          <form action="{{ route('job-categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Category Name -->
            <div>
              <x-input-label for="name" :value="__('Category Name')" />
              <x-text-input id="name"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                type="text" name="name" :value="old('name')" required autofocus />
              @error('name')
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
              @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-gray-200">
              <x-link :href="route('job-categories.index')">
                {{ __('Cancel') }}
              </x-link>

              <x-button type="submit" variant="primary">
                {{ __('+ Add Category') }}
              </x-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>