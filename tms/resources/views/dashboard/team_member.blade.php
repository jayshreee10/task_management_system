{{-- @extends('layouts.app')

@section('content')
    <h1>My Tasks</h1>

    @foreach($tasks as $status => $taskGroup)
        <h2>{{ ucfirst($status) }}</h2>
        <ul>
            @foreach($taskGroup as $task)
                <li>
                    <strong>{{ $task->title }}</strong> (Priority: {{ $task->priority }}, Due: {{ $task->due_date }})
                </li>
            @endforeach
        </ul>
    @endforeach
@endsection --}}
