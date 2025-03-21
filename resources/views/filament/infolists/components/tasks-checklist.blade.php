<div>
    @if($getRecord()->tasks->count() > 0)
        <div class="space-y-2">
            @foreach($getRecord()->tasks as $task)
                <div class="flex items-center p-2 border rounded-lg hover:bg-gray-50">
                    <div class="mr-2">
                        @if($task->status === 'Completed')
                            <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-medium">{{ $task->name }}</div>
                        <div class="text-sm text-gray-500">
                            Progreso: {{ number_format($task->progress_percentage, 2) }}% | 
                            Responsable: {{ $task->responsible ? $task->responsible->name : 'No asignado' }}
                        </div>
                    </div>
                    <div>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($task->status === 'Completed') bg-green-100 text-green-800
                            @elseif($task->status === 'In Progress') bg-blue-100 text-blue-800
                            @elseif($task->status === 'Pending') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif
                        ">
                            {{ $task->status }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-4 text-center text-gray-500">
            No hay tareas asociadas a esta fase.
        </div>
    @endif
</div>