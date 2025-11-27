<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobCategory>
 */
class JobCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $filePath = database_path('data/job_data.json');
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);
        $categories = $jobData['jobCategories'];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
