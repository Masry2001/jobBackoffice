<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Job Application') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-8 text-gray-900">
          <h3 class="text-lg font-semibold mb-6">
            {{ __("Edit Job Application") }}
          </h3>

          <form
            action="{{ route('job-applications.update', ['job_application' => $jobApplication->id, 'redirectToList' => request()->query('redirectToList')]) }}"
            method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- job vacancy details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shasow-sm">
              <h3 class="text-md font-semibold mb-4">
                {{ __('Job Application Details') }}
              </h3>
              <!-- Applicant Name -->
              <div class="mb-4">
                <x-input-label for="name" :value="__('Applicant Name')" />
                <p id="name" class="text-md text-gray-500 mb-2">{{ $jobApplication?->user?->name ?? 'N/A' }}</p>
              </div>

              <!-- Job Application Title -->
              <div class="mb-4">
                <x-input-label for="title" :value="__('Job Application Title')" />
                <p id="title" class="text-md text-gray-500 mb-2">{{ $jobApplication?->jobVacancy?->title ?? 'N/A' }}</p>
              </div>

              <!-- Company-->
              <div class="mb-4">
                <x-input-label for="company" :value="__('Company')" />
                <p id="company" class="text-md text-gray-500 mb-2">
                  {{ $jobApplication?->jobVacancy?->company?->name ?? 'N/A' }}</p>
              </div>

              <!-- ai score-->
              <div class="mb-4">
                <x-input-label for="aiScore" :value="__('Ai Score')" />
                <p id="aiScore" class="text-md text-gray-500 mb-2">
                  {{ $jobApplication->aiGeneratedScore }}
                </p>
              </div>

              <!-- ai feedback-->
              <div class="mb-4">
                <x-input-label for="aiFeedback" :value="__('Ai Feedback')" />
                <p id="aiFeedback" class="text-md text-gray-500 mb-2">
                  {{ $jobApplication->aiGeneratedFeedback }}
                </p>
              </div>

              <!-- Status-->
              <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <div class="flex items-center gap-3 mt-2">
                  <select name="status" id="status"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    onchange="updateStatusBadge(this.value)">
                    <option value="Pending" {{ old('status', $jobApplication->status) == 'Pending' ? 'selected' : '' }}>
                      Pending
                    </option>
                    <option value="Rejected" {{ old('status', $jobApplication->status) == 'Rejected' ? 'selected' : '' }}>
                      Rejected
                    </option>
                    <option value="Accepted" {{ old('status', $jobApplication->status) == 'Accepted' ? 'selected' : '' }}>
                      Accepted
                    </option>
                  </select>
                  <div class="flex-shrink-0" id="statusBadgeContainer">
                    <x-status-badge :status="old('status', $jobApplication->status)" />
                  </div>
                </div>

              </div>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-gray-200">
              <x-link :href="route('job-applications.show', $jobApplication->id)">
                {{ __('Cancel') }}
              </x-link>

              <x-button type="submit" variant="primary">
                {{ __('Update Job Application') }}
              </x-button>
            </div>
        </div>



        </form>
      </div>
    </div>
  </div>
  </div>

  <script>
    function updateStatusBadge(status) {
      const statusColors = {
        'Accepted': 'text-green-600 font-semibold',
        'Rejected': 'text-red-600 font-semibold',
        'Pending': 'text-yellow-600 font-semibold',
      };

      const container = document.getElementById('statusBadgeContainer');
      const colorClass = statusColors[status] || 'text-gray-900';

      container.innerHTML = `
        <span class="px-3 py-1 rounded-md ${colorClass}">
          ${status}
        </span>
      `;
    }
  </script>
</x-app-layout>