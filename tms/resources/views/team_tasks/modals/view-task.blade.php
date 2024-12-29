<div>
    <h3 class="text-lg font-semibold">{{ $task->name }}</h3>
    <p class="text-sm text-gray-600">{{ $task->description }}</p>
    <div class="mt-4">
        <strong>Status:</strong> {{ $task->status ?? 'Not Set' }}
    </div>
</div>
