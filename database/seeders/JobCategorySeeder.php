<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('data/job_data.json');
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);

        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate(['name' => $category]);
        }
    }
}
