<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // handle archived and active categories
        $archived = request()->query('archived', false);
        if ($archived) {
            // onlyTrashed() works because of SoftDeletes trait in the model
            $jobCategories = JobCategory::onlyTrashed()->latest()->paginate(5);
        } else {
            $jobCategories = JobCategory::latest()->paginate(5);
        }
        return view('job-category.index', compact('jobCategories', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobCategoryRequest $request)
    {
        $validated = $request->validated();
        JobCategory::create($validated);
        return redirect()->route('job-categories.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $jobCategory)
    {
        return view('job-category.edit', compact('jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobCategoryRequest $request, JobCategory $jobCategory)
    {
        $validated = $request->validated();
        $jobCategory->update($validated);
        return redirect()->route('job-categories.index')->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobCategory $jobCategory)
    {
        // Soft delete
        // sets deleted_at = now()
        $jobCategory->delete();
        return redirect()->route('job-categories.index')->with('success', 'Job category Archived successfully.');
    }

    public function restore($id)
    {
        $jobCategory = JobCategory::onlyTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()
            ->route('job-categories.index', ['archived' => true])
            ->with('success', 'Job category restored successfully.');
    }

}
