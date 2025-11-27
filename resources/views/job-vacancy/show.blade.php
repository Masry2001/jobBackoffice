<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $jobVacancy->title }}
    </h2>
  </x-slot>



  <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">
            {{ __('Job Vacancy Details') }}
          </h3>
          <p class="text-sm text-gray-600"><strong>Company:</strong> {{ $jobVacancy?->company?->name ?? 'N/A' }}</p>
          <p class="text-sm text-gray-600"><strong>Title:</strong> {{ $jobVacancy->title }}</p>
          <p class="text-sm text-gray-600"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
          <p class="text-sm text-gray-600"><strong>Type:</strong> {{ $jobVacancy->type }}</p>
          <p class="text-sm text-gray-600"><strong>Salary:</strong> ${{ $jobVacancy->salary }}</p>
          <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $jobVacancy->description }}</p>
          <p class="text-sm text-gray-600"><strong>Category:</strong> {{ $jobVacancy?->jobCategory?->name ?? 'N/A' }}
          </p>
        </div>

        <div class="flex justify-between">
          <!-- back button -->
          <div class="flex space-x-5 justify-start mb-6 ml-6">
            <x-link class="text-sm text-gray-600" href="{{ route('job-vacancies.index') }}">
              👈🏼 Back to Job Vacancies
            </x-link>
          </div>

          <!-- Edit and Archive -->
          <div class="flex space-x-5 justify-end mb-6 mr-6">

            <x-link :href="route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false'])"
              variant="primary">
              ✏️ Edit
            </x-link>
            <form
              action="{{ route('job-vacancies.destroy', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => request('redirectToList')]) }}"
              method="POST">
              @csrf
              @method('DELETE')
              <x-button type="submit" variant="default">
                🗑️ Archive
              </x-button>
            </form>

          </div>
        </div>

      </div>



      <!-- navigation tabs (jobs, applications) -->
      <div class="flex space-x-5 justify-start mt-6 ">
        <x-link class="border-b-2 border-blue-500 cursor-default hover:bg-gray-50"
          href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}">
          📑 Applications
        </x-link>

      </div>

      <div>


        <div id="applications" class="block mt-6">
          <h3 class="text-lg font-bold mb-2">Applications Content</h3>
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
              @forelse ($jobVacancy->jobApplications as $application)
                <tr>
                  <td class="py-2 px-4 border-b border-gray-200">{{ $application?->jobVacancy?->title ?? 'N/A' }}</td>
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
              @empty
                <tr>
                  <td colspan="6" class="py-2 px-4 border-b border-gray-200 text-center">No applications found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>