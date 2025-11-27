<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $Company->name }}
    </h2>
  </x-slot>



  <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">
            {{ __('Company Details') }}
          </h3>
          <p class="text-sm text-gray-600"><strong>Owner:</strong> {{ $Company?->owner?->name ?? 'N/A'}}</p>
          <p class="text-sm text-gray-600"><strong>Owner Email:</strong> {{ $Company?->owner?->email ?? 'N/A'}}</p>
          <p class="text-sm text-gray-600"><strong>Name:</strong> {{ $Company->name }}</p>
          <p class="text-sm text-gray-600"><strong>Website:</strong> @if ($Company->website)
            <a class="text-blue-600" href="{{ $Company->website }}" target="_blank" rel="noopener noreferrer">
              {{ $Company->website }}</a>
          @else
              N/A
            @endif
          </p>

          <p class="text-sm text-gray-600"><strong>Industry:</strong> {{ $Company->industry }}</p>
          <p class="text-sm text-gray-600"><strong>Address:</strong> {{ $Company->address }}</p>
        </div>

        <div class="flex {{ auth()->user()->role == 'Admin' ? 'justify-between' : 'justify-end' }}">
          <!-- back button -->
          @if (auth()->user()->role == 'Admin')
            <div class="flex space-x-5 justify-start mb-6 ml-6">
              <x-link class="text-sm text-gray-600" href="{{ route('companies.index') }}">
                👈🏼 Back to Companies
              </x-link>
            </div>
          @endif

          <!-- Edit and Archive -->
          <div class="flex space-x-5 justify-end mb-6 mr-6">
            @if (auth()->user()->role == 'Admin')

              <x-link :href="route('companies.edit', ['company' => $Company->id, 'redirectToList' => 'false'])"
                variant="primary">
                ✏️ Edit
              </x-link>
            @endif

            @if (auth()->user()->role == 'Company-Owner')

              <x-link :href="route('my-company.edit')" variant="primary">
                ✏️ Edit
              </x-link>
            @endif


            @if (auth()->user()->role == 'Admin')
              <form
                action="{{ route('companies.destroy', ['company' => $Company->id, 'redirectToList' => request('redirectToList')]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="default">
                  🗑️ Archive
                </x-button>
              </form>
            @endif

          </div>
        </div>

      </div>

      @php
        $currentTab = request('tab', 'jobs');
      @endphp

      @if (auth()->user()->role == 'Admin')
        <!-- navigation tabs (jobs, applications) -->
        <div class="flex space-x-5 justify-start mt-6 ">

          <x-link class="{{ $currentTab == 'jobs' ? 'border-b-2 border-blue-500' : '' }}"
            href="{{ route('companies.show', ['company' => $Company->id, 'tab' => 'jobs']) }}">
            💼 Jobs
          </x-link>
          <x-link class="{{ $currentTab == 'applications' ? 'border-b-2 border-blue-500' : '' }}"
            href="{{ route('companies.show', ['company' => $Company->id, 'tab' => 'applications']) }}">
            📑 Applications
          </x-link>

        </div>

        <!-- Tab Content -->
        <div>
          <!-- jobs Content -->
          <div id="jobs" class="{{ $currentTab == 'jobs' ? 'block' : 'hidden' }} mt-6">
            <h3 class="text-lg font-bold mb-2">Jobs Content</h3>

            <!-- disply the jobs in a simple table -->
            <table class="min-w-full bg-white border border-gray-200">
              <thead>
                <tr>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Job Title</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Location</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Type</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Posted Date</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($Company->jobVacancies as $job)
                  <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $job->title }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $job->location }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $job->type }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $job->created_at->format('M d, Y') }}</td>

                    <td class="py-2 px-4 border-b border-gray-200">
                      <x-link :href="route('job-vacancies.show', $job->id)" variant="indigo">
                        View
                      </x-link>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- applications Content -->
          <div id="applications" class="{{ $currentTab == 'applications' ? 'block' : 'hidden' }} mt-6">
            <h3 class="text-lg font-bold mb-2">Applications Content</h3>
            <!-- disply the applications in a simple table -->
            <table class="min-w-full bg-white border border-gray-200">
              <thead>
                <tr>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Job Title</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Applicant Name</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Email</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Applied Date</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Status</th>
                  <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>

                </tr>
              </thead>
              <tbody>
                @foreach ($Company->jobApplications as $application)
                  <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $application->jobVacancy->title }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $application?->user?->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $application?->user?->email ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $application->created_at->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $application->status }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                      <x-link :href="route('job-applications.show', $application->id)" variant="indigo">
                        View
                      </x-link>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif

    </div>
  </div>
</x-app-layout>