<!-- resources/views/team_tasks/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Task Details</h1>

    <p><strong>Task Name:</strong> {{ $task->name }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Team:</strong> {{ $task->team->name }}</p>

    <h3>Comments</h3>
    <ul>
        @foreach(json_decode($task->comments ?? '[]') as $comment)
            <li><strong>User {{ $comment->user_id }}:</strong> {{ $comment->comment }}</li>
        @endforeach
    </ul>

    <!-- Add additional task details or actions as necessary -->
@endsection
