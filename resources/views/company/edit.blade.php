@php
  if (auth()->user()->role == 'Admin') {
    $formAction = route('companies.update', ['company' => $Company->id, 'redirectToList' => request('redirectToList')]);
  } else if (auth()->user()->role == 'Company-Owner') {
    $formAction = route('my-company.update');
  }
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Company') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-8 text-gray-900">
          <h3 class="text-lg font-semibold mb-6">
            {{ __("Edit Company: {$Company->name}") }}
          </h3>

          <form action="{{ $formAction }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- company details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shasow-sm">
              <h3 class="text-md font-semibold mb-4">
                {{ __('Company Details') }}

              </h3>
              <!-- Company Name -->
              <div class="mb-4">
                <x-input-label for="name" :value="__('Company Name')" />
                <x-text-input id="name"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="name" :value="old('name', $Company->name)" required autofocus />
                @error('name')
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                @enderror
              </div>

              <!-- Company address -->
              <div class="mb-4">
                <x-input-label for="address" :value="__('Company Address')" />
                <x-text-input id="address"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="address" :value="old('address', $Company->address)" required autofocus />
                @error('address')
                  <x-input-error :messages="$errors->get('address')" class="mt-2" />
                @enderror
              </div>

              <!-- Company industry -->
              <div class="mb-4">
                <x-input-label for="industry" :value="__('Company Industry')" />
                <select name="industry" id="industry" :value="old('industry', $Company->industry)"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                  @foreach ($industries as $industry)
                    <option value="{{ $industry }}">{{ $industry }}</option>
                  @endforeach
                </select>
                @error('industry')
                  <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                @enderror
              </div>

              <!-- Company website -->
              <div class="mb-4">
                <x-input-label for="website" :value="__('Company Website (optional)')" />
                <x-text-input id="website"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="website" :value="old('website', $Company->website)" autofocus />
                @error('website')
                  <x-input-error :messages="$errors->get('website')" class="mt-2" />
                @enderror
              </div>
            </div>


            <!-- company owner details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shasow-sm">
              <h3 class="text-md font-semibold mb-4">
                {{ __('Company Owner Details') }}

              </h3>
              <!-- owner name -->
              <div class="mb-4">
                <x-input-label for="owner_name" :value="__('Owner Name')" />
                <x-text-input id="owner_name"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="owner_name" :value="old('owner_name', $Company?->owner?->name ?? 'N/A')" required
                  autofocus />
                @error('owner_name')
                  <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                @enderror
              </div>

              <!-- owner email -->
              <div class="mb-4">
                <x-input-label for="owner_email" :value="__('Owner Email')" />
                <x-text-input id="owner_email"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="owner_email" :value="old('owner_email', $Company?->owner?->email ?? 'N/A')" required
                  autofocus />
                @error('owner_email')
                  <x-input-error :messages="$errors->get('owner_email')" class="mt-2" />
                @enderror
              </div>

              <!-- owner password -->
              <div class="mt-4">
                <x-input-label for="owner_password" :value="__('Password (leave blank to keep current)')" />

                <div class="relative" x-data="{showPassword: false}">
                  <x-text-input id="owner_password" class="block mt-1 w-full" name="owner_password"
                    autocomplete="current-password" x-bind:type="showPassword ? 'text' : 'password'" />

                  <button type="button" @click="showPassword = !showPassword"
                    class="absolute flex items-center right-2 inset-y-0">
                    {{-- eye closed svg --}}
                    <svg x-show="!showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    {{-- eye open svg --}}
                    <svg x-show="showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                        fill="#1C274C" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"
                        fill="#1C274C" />
                    </svg>
                  </button>

                </div>
                @error('owner_password')
                  <x-input-error :messages="$errors->get('owner_password')" class="mt-2" />
                @enderror
              </div>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-gray-200">
              @if (auth()->user()->role == 'Admin')
                <x-link :href="route('companies.show', $Company->id)">
                  {{ __('Cancel') }}
                </x-link>
              @endif
              @if (auth()->user()->role == 'Company-Owner')

                <x-link :href="route('my-company.show')">
                  {{ __('Cancel') }}
                </x-link>
              @endif

              <x-button type="submit" variant="primary">
                {{ __('Update Company') }}
              </x-button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>