@extends('layouts.app')

@section('title',' The list of tasks')

@section('content')

        @if (count($tasks) >0)
        <div> There are tasks </div>

        @forelse ($tasks as $task)
         <div>
            <a href="{{ route('task.show', ['id' => $task->id]) }}">
                {{ $task->title }} </a>
         </div>
        @empty
        <p>No tasks</p>
        @endforelse

        @else
        <div> There are no tasks </div>
        @endif
@endsection