<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\User;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('data/job_data.json');
        $jsonData = file_get_contents($filePath);
        $jobData = json_decode($jsonData, true);

        foreach ($jobData['companies'] as $companyData) {
            // Try to find the company by name first
            $company = Company::where('name', $companyData['name'])->first();

            if ($company) {
                // Company exists — ensure it has a single owner and skip creating another
                // If you want to ensure every company has an owner, create one only if ownerId is null
                if (empty($company->ownerId)) {
                    $ownerEmail = $this->companyOwnerEmail($companyData['name']);

                    $owner = User::firstOrCreate(
                        ['email' => $ownerEmail],
                        [
                            'name' => $companyData['name'] . ' Owner',
                            'password' => 'password', // will be hashed by model cast
                            'role' => 'Company-Owner',
                            'email_verified_at' => now(),
                        ]
                    );

                    $company->ownerId = $owner->id;
                    $company->save();
                }

                // Skip creating a new company or owner — keep the original owner
                continue;
            }

            // Company does not exist — create (and create owner deterministically)
            $ownerEmail = $this->companyOwnerEmail($companyData['name']);

            $companyOwner = User::firstOrCreate(
                ['email' => $ownerEmail],
                [
                    'name' => $companyData['name'] . ' Owner',
                    'password' => 'password',
                    'role' => 'Company-Owner',
                    'email_verified_at' => now(),
                ]
            );

            Company::create([
                'name' => $companyData['name'],
                'address' => $companyData['address'] ?? null,
                'industry' => $companyData['industry'] ?? null,
                'website' => $companyData['website'] ?? null,
                'ownerId' => $companyOwner->id,
            ]);
        }
    }

    /**
     * Create a deterministic owner email from the company name.
     * e.g. "TechCore Solutions" => "techcore-solutions@companies.local"
     */
    protected function companyOwnerEmail(string $companyName): string
    {
        $slug = Str::slug($companyName);
        return "{$slug}@companies.local";
    }
}
