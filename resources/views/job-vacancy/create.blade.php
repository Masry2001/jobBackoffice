<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create Job Vacancy') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-8 text-gray-900">
          <h3 class="text-lg font-semibold mb-6">
            {{ __("Create a new Job Vacancy") }}
          </h3>

          <form action="{{ route('job-vacancies.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- job vacancy details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shasow-sm">
              <h3 class="text-md font-semibold mb-4">
                {{ __('Job Vacancy Details') }}
              </h3>
              <!-- Job Vacancy Title -->
              <div class="mb-4">
                <x-input-label for="title" :value="__('Job Vacancy Title')" />
                <x-text-input id="title"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="title" :value="old('title')" required autofocus />
                @error('title')
                  <x-input-error :messages="$errors->get('title')" class="mt-2" />
                @enderror
              </div>

              <!-- Job Vacancy Address -->
              <div class="mb-4">
                <x-input-label for="location" :value="__('Job Vacancy Location')" />
                <x-text-input id="location"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="text" name="location" :value="old('location')" required autofocus />
                @error('location')
                  <x-input-error :messages="$errors->get('location')" class="mt-2" />
                @enderror
              </div>

              <!-- job vacany salary -->
              <div class="mb-4">
                <x-input-label for="salary" :value="__('Job Vacancy Salary')" />
                <x-text-input id="salary"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  type="number" name="salary" :value="old('salary')" autofocus />
                @error('salary')
                  <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                @enderror
              </div>

              <!-- job description -->
              <div class="mb-4">
                <x-input-label for="description" :value="__('Job Vacancy Description')" />
                <textarea id="description" rows="4"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg"
                  name="description" :value="old('description')" required autofocus>{{ old('description') }}</textarea>
                @error('description')
                  <x-input-error :messages="$errors->get('description')" class="mt-2" />
                @enderror
              </div>

              <!-- Job Vacancy Type -->
              <div class="mb-4">
                <x-input-label for="type" :value="__('Job Vacancy Type')" />
                <select name="type" id="type" :value="old('type', $jobVacancy->type)"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                  <option value="Full-Time">Full-Time</option>
                  <option value="Contract">Contract</option>
                  <option value="Remote">Remote</option>
                  <option value="Hybrid">Hybrid</option>
                </select>
                @error('type')
                  <x-input-error :messages="$errors->get('type')" class="mt-2" />
                @enderror
              </div>



              <!-- Company select drobdown -->
              <div class="mb-4">
                <x-input-label for="companyId" :value="__('Company')" />
                <select name="companyId" id="companyId" :value="old('companyId', $jobVacancy->companyId)"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                  @if(auth()->user()->role == 'Admin')
                    @foreach ($companies as $company)
                      <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                  @else
                    @foreach (auth()->user()->companies as $company)
                      <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                  @endif




                </select>
                @error('companyId')
                  <x-input-error :messages="$errors->get('companyId')" class="mt-2" />
                @enderror
              </div>

              <!-- Job Category select drobdown -->
              <div class="mb-4">
                <x-input-label for="jobCategoryId" :value="__('Job Category')" />
                <select name="jobCategoryId" id="jobCategoryId"
                  :value="old('jobCategoryId', $jobVacancy->jobCategoryId)"
                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                  @foreach ($jobCategories as $jobCategory)
                    <option value="{{ $jobCategory->id }}">{{ $jobCategory->name }}</option>
                  @endforeach

                </select>
                @error('jobCategoryId')
                  <x-input-error :messages="$errors->get('jobCategoryId')" class="mt-2" />
                @enderror
              </div>



            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-gray-200">
              <x-link :href="route('job-vacancies.index')">
                {{ __('Cancel') }}
              </x-link>

              <x-button type="submit" variant="primary">
                {{ __('+ Add Job Vacancy') }}
              </x-button>
            </div>
        </div>



        </form>
      </div>
    </div>
  </div>
  </div>
</x-app-layout>