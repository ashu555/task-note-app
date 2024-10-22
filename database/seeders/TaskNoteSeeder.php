<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Note;

class TaskNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $task = Task::create([
            'subject' => 'Sample Task',
            'description' => 'This is a sample task',
            'start_date' => now(),
            'due_date' => now()->addDays(5),
            'status' => 'New',
            'priority' => 'High',
        ]);

        $task->notes()->createMany([
            [
                'subject' => 'Note 1',
                'note' => 'This is the first note',
                'attachments' => null,
            ],
            [
                'subject' => 'Note 2',
                'note' => 'This is the second note',
                'attachments' => null,
            ],
        ]);
    }
}
