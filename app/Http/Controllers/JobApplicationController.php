<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $jobApplications = JobApplication::query();

        /**
         * If the user is a company owner, limit results
         * to vacancies belonging to any of their companies.
         */
        if ($user->role == 'Company-Owner') {

            // Get ALL companies owned by this user
            $companyIds = $user->companies->pluck('id')->toArray();

            $jobApplications->whereHas('jobVacancy', function ($query) use ($companyIds) {
                $query->whereIn('companyId', $companyIds);
            });
        }

        // Handle archive toggle
        $archived = request()->boolean('archived', false);

        if ($archived) {
            $jobApplications = $jobApplications->onlyTrashed();
        }

        $jobApplications = $jobApplications->latest()->paginate(5);

        return view('job-application.index', compact('jobApplications', 'archived'));
    }





    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobApplicationRequest $request, JobApplication $jobApplication)
    {
        $validated = $request->validated();
        // update the status only
        $jobApplication->update(['status' => $validated['status']]);

        return redirect()->route('job-applications.show', $jobApplication)->with('success', 'Job Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Job Application archived successfully');
    }

    public function restore(string $id)
    {
        $jobApplication = JobApplication::onlyTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Job Application restored successfully');
    }
}
