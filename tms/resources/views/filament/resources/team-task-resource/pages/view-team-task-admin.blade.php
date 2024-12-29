{{-- Tasks for Team Section --}}
<div class="p-6 bg-black text-gray-500 shadow-lg rounded-lg">
    @if ($tasks->isEmpty())
        <p class="text-gray-600 italic">No tasks available for this team.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($tasks as $task)
                <li class="py-4 flex items-center capitalize">
                    <div class="w-full flex bg-gray-200 p-3 rounded-md gap-3">
                        <div class="w-[50%] flex-1 flex flex-col gap-2">
                            <p class="font-semibold text-sm text-gray-500">{{ $task->title }}</p>
                            <p class="text-xs text-gray-500">{{ $task->description }}</p>
                        </div>

                        <p class="flex items-center justify-center px-2 text-center text-xs rounded-lg">
                            {{ ucfirst($task->status) }}
                        </p>

                        {{-- Edit Button (visible only for Admin or Manager) --}}
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))
                            <a href="{{ url('/admin/team-tasks/' . $task->id . '/edit') }}"
                               class="ml-4 bg-gray-400 flex items-center text-gray-100 justify-center px-4 py-2 text-xs rounded-lg">
                                Edit
                            </a>
                        @endif

                        {{-- Add Comment Button (for other users) --}}
                        @if(auth()->user()->hasRole('Team Member'))

                        <a href="{{ url('team-tasks/' . $task->id . '/view') }}"
                           class="ml-4 bg-gray-400 flex items-center text-white justify-center px-4 py-2 text-xs rounded-lg">
                            Add Comment
                        </a>
                        @endif

                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
