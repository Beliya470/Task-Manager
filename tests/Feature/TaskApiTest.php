<?php

namespace Tests\Feature;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    private function makeTask(array $overrides = []): Task
    {
        return Task::create(array_merge([
            'title' => 'Sample task',
            'due_date' => now()->addDay()->format('Y-m-d'),
            'priority' => 'medium',
            'status' => 'pending',
        ], $overrides));
    }

    public function test_can_create_a_task(): void
    {
        $res = $this->postJson('/api/tasks', [
            'title' => 'Fix login bug',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
            'priority' => 'high',
        ]);

        $res->assertStatus(201)
            ->assertJsonPath('task.title', 'Fix login bug')
            ->assertJsonPath('task.status', 'pending');
    }

    public function test_cannot_create_task_with_past_due_date(): void
    {
        $res = $this->postJson('/api/tasks', [
            'title' => 'Old task',
            'due_date' => now()->subDay()->format('Y-m-d'),
            'priority' => 'low',
        ]);

        $res->assertStatus(422);
    }

    public function test_cannot_create_duplicate_title_on_same_date(): void
    {
        $date = now()->addDays(3)->format('Y-m-d');

        $this->makeTask(['title' => 'Duplicate task', 'due_date' => $date]);

        $res = $this->postJson('/api/tasks', [
            'title' => 'Duplicate task',
            'due_date' => $date,
            'priority' => 'low',
        ]);

        $res->assertStatus(422);
    }

    public function test_can_list_all_tasks(): void
    {
        $this->makeTask(['title' => 'Task A']);
        $this->makeTask(['title' => 'Task B']);

        $res = $this->getJson('/api/tasks');

        $res->assertStatus(200)
            ->assertJsonStructure(['message', 'count', 'tasks'])
            ->assertJsonCount(2, 'tasks');
    }

    public function test_can_filter_tasks_by_status(): void
    {
        $this->makeTask(['title' => 'Pending task', 'status' => 'pending']);
        $this->makeTask(['title' => 'Done task', 'due_date' => now()->subDay()->format('Y-m-d'), 'status' => 'done']);

        $res = $this->getJson('/api/tasks?status=pending');

        $res->assertStatus(200);

        foreach ($res->json('tasks') as $task) {
            $this->assertEquals('pending', $task['status']);
        }
    }

    public function test_returns_empty_array_when_no_tasks(): void
    {
        $res = $this->getJson('/api/tasks');

        $res->assertStatus(200)
            ->assertJson(['message' => 'No tasks found', 'tasks' => []]);
    }

    public function test_can_advance_status_from_pending_to_in_progress(): void
    {
        $task = $this->makeTask(['status' => 'pending']);

        $res = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'in_progress']);

        $res->assertStatus(200)
            ->assertJsonPath('task.status', 'in_progress');
    }

    public function test_can_advance_status_from_in_progress_to_done(): void
    {
        $task = $this->makeTask(['status' => 'in_progress']);

        $res = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'done']);

        $res->assertStatus(200)
            ->assertJsonPath('task.status', 'done');
    }

    public function test_cannot_skip_status(): void
    {
        $task = $this->makeTask(['status' => 'pending']);

        $res = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'done']);

        $res->assertStatus(422);
    }

    public function test_cannot_revert_status(): void
    {
        $task = $this->makeTask(['status' => 'in_progress']);

        $res = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'pending']);

        $res->assertStatus(422);
    }

    public function test_can_delete_completed_task(): void
    {
        $task = $this->makeTask([
            'due_date' => now()->subDay()->format('Y-m-d'),
            'status' => 'done',
        ]);

        $res = $this->deleteJson("/api/tasks/{$task->id}");

        $res->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_cannot_delete_incomplete_task(): void
    {
        $task = $this->makeTask(['status' => 'pending']);

        $res = $this->deleteJson("/api/tasks/{$task->id}");

        $res->assertStatus(403);
    }

    public function test_daily_report_returns_correct_format(): void
    {
        $date = now()->addDays(2)->format('Y-m-d');

        $this->makeTask(['title' => 'Task 1', 'due_date' => $date, 'priority' => 'high', 'status' => 'pending']);
        $this->makeTask(['title' => 'Task 2', 'due_date' => $date, 'priority' => 'medium', 'status' => 'in_progress']);

        $res = $this->getJson("/api/tasks/report?date={$date}");

        $res->assertStatus(200)
            ->assertJsonStructure([
                'date',
                'summary' => [
                    'high' => ['pending', 'in_progress', 'done'],
                    'medium' => ['pending', 'in_progress', 'done'],
                    'low' => ['pending', 'in_progress', 'done'],
                ],
                'total_tasks',
            ])
            ->assertJsonPath('total_tasks', 2)
            ->assertJsonPath('summary.high.pending', 1)
            ->assertJsonPath('summary.medium.in_progress', 1);
    }
}
