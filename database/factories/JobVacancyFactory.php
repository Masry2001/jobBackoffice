<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobCategory;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobVacancy>
 */
class JobVacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Path to JSON data
        $filePath = database_path('data/job_data.json');

        // Decode the file
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);

        // Access job vacancies array
        $jobVacancies = $jobData['jobVacancies'];

        // Pick one random job from JSON
        $job = $this->faker->randomElement($jobVacancies);

        // Find existing related category and company
        $category = JobCategory::where('name', $job['category'])->firstOrFail();
        $company = Company::where('name', $job['company'])->firstOrFail();

        return [
            'title' => $job['title'],
            'description' => $job['description'],
            'category_id' => $category->id,
            'company_id' => $company->id,
            'location' => $job['location'],
            'salary' => $job['salary'],
            'type' => $job['type'],
        ];
    }
}
