<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TodoList;
class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TodoList::create([
            'user_id' => 1,
            'title' => 'Finish Laravel project',
            'description' => 'Finish the project and test it',
            'status' => \App\StatusEnum::DONE,
            'priority' => '1',
            'parent_id' => null,
            'completedAt' => "2024-07-13 20:00:00",
        ]);

        TodoList::create([
            'user_id' => 1,
            'title' => 'Prepare sales report',
            'description' => 'Collect data and prepare a report for the current month',
            'status' => \App\StatusEnum::TODO,
            'priority' => '2',
            'parent_id' => 1,
            'completedAt' => "2024-06-18 12:04:55",
        ]);
        TodoList::create([
            'user_id' => 1,
            'title' => 'Make charts for reports',
            'description' => 'Make charts for reports',
            'status' => \App\StatusEnum::TODO,
            'priority' => '3',
            'parent_id' => 1,
            'completedAt' => "2024-06-21 08:04:55",
        ]);
        TodoList::create([
            'user_id' => 2,
            'title' => 'Write a calculator',
            'description' => 'Write a calculator for home',
            'status' => \App\StatusEnum::TODO,
            'priority' => '3',
            'parent_id' => null,
            'completedAt' => "2024-08-21 08:04:55",
        ]);
    }
}
