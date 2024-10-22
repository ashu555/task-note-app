<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function store(Request $request, $task_id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'note' => 'required|string',
            'attachments' => 'array',
            'attachments.*' => 'file|mimes:jpg,png,pdf|max:2048' // Add any other file types as needed
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the task exists
        $task = Task::find($task_id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Create the note
        $note = new Note();
        $note->subject = $request->subject;
        $note->note = $request->note;
        $note->task_id = $task_id;

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments'); // Store the file and get the path
                $attachments[] = $path; // Store the file path in an array
            }
            $note->attachments = json_encode($attachments); // Store the paths as JSON
        }

        // Save the note
        $note->save();

        return response()->json(['message' => 'Note added successfully'], 201);
    }
}
