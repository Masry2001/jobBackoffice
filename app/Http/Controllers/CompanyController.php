<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{

    public $industries = [
        'Technology',
        'IT',
        'Healthcare',
        'Finance',
        'Education',
        'Other'
    ];
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // handle archived and active
        $archived = request()->query('archived', false);
        if ($archived) {
            // onlyTrashed() works because of SoftDeletes trait in the model
            $companies = Company::onlyTrashed()->latest()->paginate(5);
        } else {
            $companies = Company::latest()->paginate(5);
        }
        return view('company.index', compact('companies', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        // validate company and owner data
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // 1 Create owner
            $owner = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => $validated['owner_password'],
                'role' => 'Company-Owner'
            ]);

            if (!$owner) {
                throw new \Exception('owner_creation_failed');
            }

            // 2 Create company
            $company = Company::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'industry' => $validated['industry'],
                'website' => $validated['website'],
                'ownerId' => $owner->id,
            ]);

            if (!$company) {
                throw new \Exception('company_creation_failed');
            }

            DB::commit();

            return redirect()->route('companies.index')
                ->with('success', 'Company created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            // Customize message based on error code
            if ($e->getMessage() === 'owner_creation_failed') {
                $errorMsg = 'Failed to create company because the owner could not be created.';
            } elseif ($e->getMessage() === 'company_creation_failed') {
                $errorMsg = 'Failed to create company because the company record could not be created.';
            } else {
                $errorMsg = 'An unexpected error occurred while creating the company.';
            }

            return back()->with('error', $errorMsg);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $Company = null)
    {
        if (!$Company) {
            $Company = Company::where('ownerId', auth()->user()->id)->first();
        }
        return view('company.show', compact('Company'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $Company = null)
    {
        if (!$Company) {
            $Company = Company::where('ownerId', auth()->user()->id)->first();
        }
        $industries = $this->industries;

        return view('company.edit', compact('industries', 'Company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $Company = null)
    {
        if (!$Company) {
            $Company = Company::where('ownerId', auth()->user()->id)->first();
        }
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // 1. Update company details
            $Company->update([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'industry' => $validated['industry'],
                'website' => $validated['website'],
            ]);

            // 2. Update owner details
            $owner = $Company->owner;
            $ownerData = [
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
            ];

            if (!empty($validated['owner_password'])) {
                $ownerData['password'] = $validated['owner_password'];
            }

            $owner->update($ownerData);

            DB::commit();

            if (auth()->user()->role == 'Company-Owner') {
                return redirect()->route('my-company.show')->with('success', 'Company updated successfully.');
            }

            if ($request->query('redirectToList') == 'true') {
                return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
            }

            return redirect()->route('companies.show', $Company)->with('success', 'Company updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while updating the company.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $Company)
    {
        // Soft delete
        // sets deleted_at = now()
        $Company->delete();
        return redirect()->route('companies.index')->with('success', 'Company Archived successfully.');
    }

    public function restore($id)
    {
        $Company = Company::onlyTrashed()->findOrFail($id);
        $Company->restore();

        return redirect()
            ->route('companies.index', ['archived' => true])
            ->with('success', 'Company restored successfully.');
    }

}