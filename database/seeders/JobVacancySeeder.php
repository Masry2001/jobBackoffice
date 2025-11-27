<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobVacancy;
use App\Models\JobCategory;
use App\Models\Company;
class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('data/job_data.json');
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);

        foreach ($jobData['jobVacancies'] as $jobVacancy) {
            JobVacancy::firstOrCreate([
                'title' => $jobVacancy['title'],
                'companyId' => Company::where('name', $jobVacancy['company'])->firstOrFail()->id,
            ], [
                'description' => $jobVacancy['description'],
                'jobCategoryId' => JobCategory::where('name', $jobVacancy['category'])->firstOrFail()->id,
                'companyId' => Company::where('name', $jobVacancy['company'])->firstOrFail()->id,
                'location' => $jobVacancy['location'],
                'salary' => $jobVacancy['salary'],
                'type' => $jobVacancy['type'],
            ]);
        }
    }
}
