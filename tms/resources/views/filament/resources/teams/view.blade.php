<div class="p-4 bg-white rounded-lg shadow-md space-y-3 border">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">{{ $record->name }}</h3>
        <div class="flex space-x-2">
            @if($record->users->count() > 0)
                <span class="bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded">
                    {{ $record->users->count() }} Users
                </span>
            @endif
            <span class="bg-success-100 text-success-800 text-xs px-2 py-1 rounded">
                {{ \App\Models\Task::where('team_id', $record->id)->count() }} Tasks
            </span>
        </div>
    </div>

    @if($record->description)
        <p class="text-gray-600 text-sm line-clamp-2">
            {{ Str::limit($record->description, 100) }}
        </p>
    @endif

    <div class="flex items-center space-x-2">
        <div class="flex -space-x-2">
            @foreach($record->users->take(3) as $user)
                <img
                    src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                    alt="{{ $user->name }}"
                    class="w-8 h-8 rounded-full border-2 border-white"
                />
            @endforeach
            @if($record->users->count() > 3)
                <span class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-xs">
                    +{{ $record->users->count() - 3 }}
                </span>
            @endif
        </div>
    </div>

    <div class="flex justify-end space-x-2 mt-3">
        {{ $getAction('edit') }}
    </div>
</div>
