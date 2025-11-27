<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'Admin') {
            $analytics = $this->adminAnalytics();

        } elseif ($user->role === 'Company-Owner') {
            $analytics = $this->companyAnalytics($user);
        }

        return view('dashboard.index', compact('analytics'));
    }

    /**
     * ------------------------------
     * ADMIN ANALYTICS
     * ------------------------------
     */
    private function adminAnalytics()
    {
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'Job-Seeker')
            ->count();

        $totalJobVacancies = JobVacancy::count();
        $totalJobApplications = JobApplication::count();

        return [
            'activeUsers' => $activeUsers,
            'totalJobVacancies' => $totalJobVacancies,
            'totalJobApplications' => $totalJobApplications,
            'mostAppliedJobs' => $this->getMostAppliedJobs(),
            'conversionRates' => $this->getConversionRates(),
        ];
    }

    /**
     * ------------------------------
     * COMPANY OWNER ANALYTICS
     * ------------------------------
     */
    private function companyAnalytics($user)
    {
        // Owners can have many companies
        $companyIds = $user->companies->pluck('id')->toArray();

        // Active Job-Seekers (same for all companies)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'Job-Seeker')
            ->count();

        // Total job vacancies owned by those companies
        $totalJobVacancies = JobVacancy::whereIn('companyId', $companyIds)->count();

        // Total job applications for those vacancies
        $totalJobApplications = JobApplication::whereHas('jobVacancy', function ($query) use ($companyIds) {
            $query->whereIn('companyId', $companyIds);
        })->count();

        return [
            'activeUsers' => $activeUsers,
            'totalJobVacancies' => $totalJobVacancies,
            'totalJobApplications' => $totalJobApplications,
            'mostAppliedJobs' => $this->getMostAppliedJobs($companyIds),
            'conversionRates' => $this->getConversionRates($companyIds),
        ];
    }


    /**
     * ------------------------------
     * TOP 5 MOST APPLIED JOBS
     * ------------------------------
     */
    private function getMostAppliedJobs($companyIds = null)
    {
        $query = JobVacancy::withCount('jobApplications as totalCount')
            ->with('company')
            ->whereNull('deleted_at');

        // If company owner → filter by owned companies
        if ($companyIds) {
            $query->whereIn('companyId', $companyIds);
        }

        return $query->orderBy('totalCount', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * ------------------------------
     * TOP 5 CONVERSION RATE JOBS
     * ------------------------------
     */
    private function getConversionRates($companyIds = null)
    {
        $query = JobVacancy::select('job_vacancies.*')
            ->selectRaw('
                (SELECT count(*) 
                 FROM job_applications 
                 WHERE job_vacancies.id = job_applications.jobVacancyId) as totalCount,

                CASE WHEN COALESCE(viewCount,0) > 0 
                     THEN (
                        (SELECT count(*) 
                         FROM job_applications 
                         WHERE job_vacancies.id = job_applications.jobVacancyId)
                        / viewCount
                     ) * 100
                     ELSE 0 
                END as conversionRate
            ');

        // Filter for company owners only
        if ($companyIds) {
            $query->whereIn('companyId', $companyIds);
        }

        return $query->having('totalCount', '>', 0)
            ->orderBy('totalCount', 'desc')
            ->limit(5)
            ->get();
    }
}
