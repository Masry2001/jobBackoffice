<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['Pending', 'Accepted', 'Rejected'];

        return [
            'status' => $this->faker->randomElement($statuses),

            // Optional AI-related fields
            'aiGeneratedScore' => $this->faker->randomFloat(2, 0, 100),
            'aiGeneratedFeedback' => $this->faker->sentence(),

            // Relations
            'userId' => User::inRandomOrder()->value('id') ?? User::factory(),
            'jobVacancyId' => JobVacancy::inRandomOrder()->value('id') ?? JobVacancy::factory(),
            'resumeId' => Resume::inRandomOrder()->value('id') ?? Resume::factory(),
        ];
    }
}
