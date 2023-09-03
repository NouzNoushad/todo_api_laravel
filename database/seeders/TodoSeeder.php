<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todoJson = File::get('database/json/todo.json');
        $todo = collect(json_decode($todoJson));
        $todo->each(function($t){
            Todo::create([
                'title' => $t->title,
                'content' => $t->content
            ]);
        });
    }
}
