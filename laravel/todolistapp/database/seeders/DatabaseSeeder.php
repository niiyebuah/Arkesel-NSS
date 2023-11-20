<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TasksTableSeeder extends Seeder
{
    public function run()
    {
        // Define the number of tasks you want to create
        $numberOfTodos = 10;

        // Create fake tasks using the Todo model factory
        Todo::factory($numberOfTodos)->create();
    }
}