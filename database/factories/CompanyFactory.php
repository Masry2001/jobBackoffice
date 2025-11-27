<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $filePath = database_path('data/job_data.json');
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);
        $companies = $jobData['companies'];

        $company = $this->faker->randomElement($companies);
        $owner = User::where('role', 'Admin')->first();

        return [
            'name' => $company['name'],
            'address' => $company['address'],
            'industry' => $company['industry'],
            'website' => $company['website'],
            'ownerId' => $owner->id,
        ];
    }
}
