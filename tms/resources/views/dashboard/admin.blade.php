{{-- @extends('layouts.app')

@section('content')
    <h1>All Tasks</h1>

    <!-- Filter Form -->
    <form method="GET">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="in progress">In Progress</option>
            <option value="complete">Completed</option>
        </select>
        <select name="priority">
            <option value="">All Priorities</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
        <select name="assigned_to">
            <option value="">All Users</option>
            @foreach(\App\Models\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Tasks Table -->
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Assigned To</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ optional($task->assignedTo)->name ?? 'Unassigned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tasks->links() }}
@endsection --}}
