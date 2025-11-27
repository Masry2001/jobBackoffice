<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Job Application Details') }}
    </h2>
  </x-slot>



  <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">
            {{ __('Application Details') }}
          </h3>
          <p class="text-sm text-gray-600"><strong>Applicant:</strong> {{ $jobApplication?->user?->name ?? 'N/A'  }}</p>
          <p class="text-sm text-gray-600"><strong>Job Vacancy:</strong>
            {{ $jobApplication?->jobVacancy?->title ?? 'N/A' }}</p>
          <p class="text-sm text-gray-600"><strong>Company:</strong>
            {{ $jobApplication?->jobVacancy?->company?->name ?? 'N/A' }}
          </p>
          @if($jobApplication?->resume?->fileUri)
            <p class="text-sm text-gray-600"><strong>Resume:</strong>
              <a class="text-blue-600 hover:underline" href="{{ $jobApplication->resume->fileUri }}" target="_blank"
                rel="noopener noreferrer">
                {{ $jobApplication->resume->fileUri }}
              </a>
            </p>
          @else
            <p class="text-sm text-gray-600"><strong>Resume:</strong> N/A</p>
          @endif
          <p class="text-sm text-gray-600"><strong>Status:</strong> <x-status-badge :status="$jobApplication->status" />
          </p>
        </div>

        <div class="flex justify-between">
          <!-- back button -->
          <div class="flex space-x-5 justify-start mb-6 ml-6">
            <x-link class="text-sm text-gray-600" href="{{ route('job-applications.index') }}">
              👈🏼 Back to Job Applications
            </x-link>
          </div>

          <!-- Edit and Archive -->
          <div class="flex space-x-5 justify-end mb-6 mr-6">

            <x-link :href="route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false'])" variant="primary">
              ✏️ Edit
            </x-link>
            <form
              action="{{ route('job-applications.destroy', ['job_application' => $jobApplication->id, 'redirectToList' => request('redirectToList')]) }}"
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

      @php
        $currentTab = request('tab', 'resume');
      @endphp

      <!-- navigation tabs (resume, AiFeedback) -->
      <div class="flex space-x-5 justify-start mt-6 ">

        <x-link class="{{ $currentTab == 'resume' ? 'border-b-2 border-blue-500' : '' }}"
          href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}">
          📄 Resume
        </x-link>
        <x-link class="{{ $currentTab == 'AiFeedback' ? 'border-b-2 border-blue-500' : '' }}"
          href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AiFeedback']) }}">
          🤖 AiFeedback
        </x-link>

      </div>

      <!-- Tab Content -->
      <div>
        <div id="resume" class="{{ $currentTab == 'resume' ? 'block' : 'hidden' }} mt-6">
          @if ($jobApplication->resume)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                  <h4 class="text-lg font-semibold mb-2">Summary</h4>
                  <p class="text-sm text-gray-700 mb-4">{{ $jobApplication->resume->summary }}</p>

                  <h4 class="text-lg font-semibold mb-2">Skills</h4>
                  <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $jobApplication->resume->skills ?? '') as $skill)
                      @if(trim($skill) !== '')
                        <span
                          class="inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">{{ trim($skill) }}</span>
                      @endif
                    @endforeach
                  </div>
                </div>

                <div class="md:col-span-2">
                  <h4 class="text-lg font-semibold mb-2">Experience</h4>
                  <div class="mb-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $jobApplication->resume->experience }}</p>
                  </div>

                  <h4 class="text-lg font-semibold mb-2">Education</h4>
                  <div>
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $jobApplication->resume->education }}</p>
                  </div>
                </div>
              </div>
            </div>
          @else
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-sm text-gray-600">
              Resume not provided for this application.
            </div>
          @endif
        </div>

        <!-- disply the AiFeedbadk in a simple table -->

        <div id="AiFeedback" class="{{ $currentTab == 'AiFeedback' ? 'block' : 'hidden' }} mt-6">
          <h3 class="text-lg font-bold mb-2">AiFeedback Content</h3>
          <table class="min-w-full bg-white border border-gray-200">
            <thead>
              <tr>
                <th class="py-2 px-4 border-b border-gray-200 text-left whitespace-nowrap">Ai Score</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Feedback</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-2 px-4 border-b border-gray-200">{{ $jobApplication->aiGeneratedScore }}</td>
                <td class="py-2 px-4 border-b border-gray-200">{{ $jobApplication->aiGeneratedFeedback }}</td>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>