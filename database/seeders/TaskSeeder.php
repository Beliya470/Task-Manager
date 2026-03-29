<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Fix M-Pesa payment callback bug',
                'due_date' => now()->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'in_progress',
            ],
            [
                'title' => 'Update Q1 revenue report for management',
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Review pull request #47 - user auth module',
                'due_date' => now()->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Prepare onboarding docs for new Nairobi office hires',
                'due_date' => now()->addDays(5)->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Deploy updated build to staging server',
                'due_date' => now()->addDays(1)->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Write unit tests for KES currency conversion module',
                'due_date' => now()->addDays(4)->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'in_progress',
            ],
            [
                'title' => 'Follow up on client meeting notes - Safaricom project',
                'due_date' => now()->addDays(1)->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Configure automated daily database backups',
                'due_date' => now()->addDays(3)->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Optimise homepage load time on low bandwidth',
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'priority' => 'low',
                'status' => 'pending',
            ],
            [
                'title' => 'Update third-party package dependencies',
                'due_date' => now()->addDays(6)->format('Y-m-d'),
                'priority' => 'low',
                'status' => 'pending',
            ],
            [
                'title' => 'Set up CI/CD pipeline on GitHub Actions',
                'due_date' => Carbon::parse('2026-03-20')->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'done',
            ],
            [
                'title' => 'Design API documentation page',
                'due_date' => Carbon::parse('2026-03-18')->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'done',
            ],
            [
                'title' => 'Refactor user authentication flow',
                'due_date' => Carbon::parse('2026-03-15')->format('Y-m-d'),
                'priority' => 'high',
                'status' => 'done',
            ],
            [
                'title' => 'Add rate limiting to public API endpoints',
                'due_date' => now()->addDays(8)->format('Y-m-d'),
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Archive old project assets from Google Drive',
                'due_date' => Carbon::parse('2026-03-22')->format('Y-m-d'),
                'priority' => 'low',
                'status' => 'done',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
