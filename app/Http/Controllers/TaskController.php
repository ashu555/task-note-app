<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;


class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|in:New,Incomplete,Complete',
            'priority' => 'required|in:High,Medium,Low',
            'notes' => 'required|array',
            'notes.*.subject' => 'required|string',
            'notes.*.note' => 'required|string',
            'notes.*.attachments' => 'nullable|array',
        ]);

        $task = Task::create($request->only(['subject', 'description', 'start_date', 'due_date', 'status', 'priority']));

        foreach ($request->notes as $noteData) {
            $note = new Note([
                'subject' => $noteData['subject'],
                'note' => $noteData['note'],
                'attachments' => json_encode($noteData['attachments'] ?? [])
            ]);
            $task->notes()->save($note);
        }

        return response()->json(['message' => 'Task created successfully', 'task' => $task->load('notes')], 201);
    }

   public function index(Request $request)
    {
        // Initialize a query to get tasks with notes
        $tasks = Task::with('notes')
            ->withCount('notes') // Count the notes directly in the main query
            ->when($request->filter['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($request->filter['due_date'] ?? null, fn ($query, $dueDate) => $query->where('due_date', $dueDate))
            ->when($request->filter['priority'] ?? null, fn ($query, $priority) => $query->where('priority', $priority))
            ->when($request->filter['notes'] ?? null, fn ($query) => $query->has('notes'))
            ->orderBy('priority', 'desc')
            ->orderBy('notes_count', 'desc') // Sort by the count of notes
            ->get();

        return response()->json($tasks);
    }




}
