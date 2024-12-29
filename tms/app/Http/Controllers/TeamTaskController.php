<?php

// app/Http/Controllers/TeamTaskController.php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Task;
use Illuminate\Http\Request;

class TeamTaskController extends Controller
{
    public function index()
    {

        $tasks = auth()->user()->teams->flatMap(function ($team) {
            return $team->tasks;
        });

        return view('team_tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->validate($request, ['status' => 'required|in:completed']);

        $task->update(['status' => $request->status]);

        return back();
    }



}

