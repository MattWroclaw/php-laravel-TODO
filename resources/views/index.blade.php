@extends('layouts.app')

@section('title',' The list of tasks')

@section('content')
        <nav class="mb-4">
                <a href="{{route('tasks.create')}}" 
                class="font-medium text-gray-700 underline decoration-pink-500">Add task</a>
        </nav>

        @if (count($tasks) >0)
        <div> There are tasks </div>

        @forelse ($tasks as $task)
         <div>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
            @class(['line-through'=> $task->completed, 'italic'])>
                {{ $task->title }} </a>
         </div>
        @empty
        <p>No tasks</p>
        @endforelse

        @else
        <div> There are no tasks </div>
        @endif


        @if ($tasks->count())
        <nav class="mt-4">
                {{ $tasks->links() }}
        </nav>
        @endif
@endsection