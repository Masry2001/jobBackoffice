<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\Resume;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('data/job_applications.json');
        $jsonData = file_get_contents($filePath);
        $jobApplications = json_decode($jsonData, true);

        foreach ($jobApplications['jobApplications'] as $application) {

            // Pick a random existing job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // Create a job seeker
            $jobSeeker = User::factory()
                ->state(['role' => 'Job-Seeker'])
                ->create();

            // Create a resume for this seeker
            $resume = Resume::create([
                'userId' => $jobSeeker->id,
                'filename' => $application['resume']['filename'],
                'fileUri' => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'summary' => $application['resume']['summary'],
                'skills' => $application['resume']['skills'],
                'experience' => $application['resume']['experience'],
                'education' => $application['resume']['education'],
            ]);

            // Create the job application (avoid duplicates)
            JobApplication::firstOrCreate(
                [
                    'userId' => $jobSeeker->id,
                    'jobVacancyId' => $jobVacancy->id,
                ],
                [
                    'status' => $application['status'],
                    'aiGeneratedScore' => $application['aiGeneratedScore'],
                    'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
                    'resumeId' => $resume->id,
                ]
            );
        }
    }
}
