<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's data.
     */
    public function run(): void
    {
        // Create Manager
        $manager = User::create([
            'name' => 'Sarah Manager',
            'email' => 'manager@officeflow.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // Create Employee
        $employee = User::create([
            'name' => 'Abrar Employee',
            'email' => 'employee@officeflow.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // Create tasks with advanced attributes
        $t1 = Task::create([
            'user_id' => $employee->id,
            'title' => 'Fix Authentication Bug',
            'description' => 'The login page is timing out for some users. Investigating session drivers.',
            'status' => 'Pending',
            'priority' => 'High',
            'due_date' => now()->addDays(2),
            'category' => 'Bug',
        ]);

        $t2 = Task::create([
            'user_id' => $employee->id,
            'title' => 'Implement REST API',
            'description' => 'Drafting the new API routes for task management.',
            'status' => 'In Review',
            'priority' => 'Medium',
            'due_date' => now()->subDay(), // Overdue
            'category' => 'Feature',
        ]);

        Task::create([
            'user_id' => $employee->id,
            'title' => 'Update Branding',
            'description' => 'The logo needs to be updated in the dashboard header.',
            'status' => 'Approved',
            'priority' => 'Low',
            'due_date' => now()->addWeek(),
            'category' => 'General',
        ]);

        // Seed Activities
        Activity::create([
            'user_id' => $employee->id,
            'task_id' => $t1->id,
            'type' => 'created',
            'description' => 'created task: Fix Authentication Bug',
        ]);

        Activity::create([
            'user_id' => $manager->id,
            'task_id' => $t2->id,
            'type' => 'status_updated',
            'description' => 'marked task as In Review',
        ]);
    }
}
