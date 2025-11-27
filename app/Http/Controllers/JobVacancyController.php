<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobVacancyRequest;
use App\Http\Requests\UpdateJobVacancyRequest;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = JobVacancy::query();

        // Filter by company if user is a Company-Owner
        if (auth()->user()->role == 'Company-Owner') {
            $companyIds = auth()->user()->companies->pluck('id')->toArray();
            $query->whereIn('companyId', $companyIds);
        }

        // Handle archived and active toggle
        $archived = request()->query('archived', false);
        if ($archived) {
            // onlyTrashed() works because of SoftDeletes trait in the model
            $query->onlyTrashed();
        }

        $jobVacancies = $query->latest()->paginate(5);
        return view('job-vacancy.index', compact('jobVacancies', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancy.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobVacancyRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route('job-vacancies.index')->with('success', 'Job Vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacancy $jobVacancy)
    {
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobVacancyRequest $request, JobVacancy $jobVacancy)
    {
        $validated = $request->validated();
        $jobVacancy->update($validated);
        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('job-vacancies.index')->with('success', 'Job Vacancy updated successfully');
        }
        return redirect()->route('job-vacancies.show', $jobVacancy->id)->with('success', 'Job Vacancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job Vacancy deleted successfully');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::onlyTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route('job-vacancies.index', ['archived' => true])->with('success', 'Job Vacancy restored successfully');
    }
}
