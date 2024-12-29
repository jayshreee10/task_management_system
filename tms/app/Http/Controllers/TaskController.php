<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Task::class, 'task');
    }


    public function store(Request $request)
    {


        $this->authorize('create-task');


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in progress,complete',
            'due_date' => 'nullable|date',
            'created_by' => 'nullable|exists:users,id',
            'priority' => 'required|in:High,Medium,Low',
        ]);


        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'created_by' => $validated['created_by'] ?? auth()->id(),
            'priority' => $validated['priority'],
            'comments' => [],
            'attachments' => [],
        ]);

        broadcast(new TaskCreated($task));
        \Log::info('TaskController data:', ['task' => $task]);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }


    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }


    public function assign(Task $task)
    {
        $this->authorize('assign-task');

    }


    public function show(Task $task)
    {
        $this->authorize('view-task', $task);

    }


    public function update(Request $request, Task $task)

    {

        $this->authorize('update-task', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in progress,complete',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:High,Medium,Low',
            'comments' => [],
            'attachments' => [],
        ]);


        $task->update($validated);
        Log::alert("Task updated successfully!");

        return redirect()->route('tasks.index')->with('Task updated successfully!', 'Task updated successfully!');
    }


    public function destroy(Task $task)

    {
        $this->authorize('delete-task', $task);
        $task->delete();


        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

        public function teamTasks(Team $team)
    {
        $tasks = $team->tasks()->with('user')->get();

        return view('tasks.team-overview', compact('team', 'tasks'));
    }



}
