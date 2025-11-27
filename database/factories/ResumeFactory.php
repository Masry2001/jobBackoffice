<?php

namespace Database\Factories;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Resume>
 */
class ResumeFactory extends Factory
{
    protected $model = Resume::class;

    public function definition(): array
    {

        $filePath = database_path('data/job_applications.json');
        $jsonData = file_get_contents($filePath);
        $jobApplications = json_decode($jsonData, true);
        // pick or create a random user
        $userId = User::inRandomOrder()->value('id') ?? User::factory()->create()->id;

        return [
            'fileName' => $jobApplications['resume']['filename'],
            'fileUri' => 'resumes/' . $jobApplications['resume']['filename'],
            'contactDetails' => $jobApplications['resume']['contactDetails'],
            'summary' => $jobApplications['resume']['summary'],
            'skills' => $jobApplications['resume']['skills'],
            'experience' => $jobApplications['resume']['experience'],
            'education' => $jobApplications['resume']['education'],
            'userId' => $userId,
        ];
    }
}
