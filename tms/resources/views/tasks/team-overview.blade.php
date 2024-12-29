<h1>Tasks for Team: {{ $team->name }}</h1>
<table>
    <thead>
        <tr>
            <th>Task</th>
            <th>Assigned To</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
