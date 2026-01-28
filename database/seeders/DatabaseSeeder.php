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
        // Database is now empty - users can register fresh accounts
        // No demo data to avoid email conflicts during registration
    }
}
