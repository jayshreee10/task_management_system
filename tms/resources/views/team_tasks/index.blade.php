// resources/views/team_tasks/index.blade.php
@foreach($tasks as $task)
    <div class="task">
        <h4>{{ $task->name }}</h4>
        <p>{{ $task->description }}</p>
        <span>Status: {{ $task->status }}</span>

        @if($task->status == 'completed')
            <form method="POST" action="{{ route('tasks.comment', $task) }}">
                @csrf
                <textarea name="comment" placeholder="Add a comment"></textarea>
                <button type="submit">Add Comment</button>
            </form>
        @endif
    </div>
@endforeach
