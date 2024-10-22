<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $tasks = Task::with('notes')
            ->when($request->filter['status'], function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->filter['due_date'], function ($query, $due_date) {
                return $query->where('due_date', $due_date);
            })
            ->when($request->filter['priority'], function ($query, $priority) {
                return $query->where('priority', $priority);
            })
            ->when($request->filter['notes'], function ($query) {
                return $query->has('notes');
            })
            ->orderBy('priority', 'desc')
            ->get();

        return response()->json($tasks);
    }


}
