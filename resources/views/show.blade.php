@extends('layouts.app')

@section('title', $task ->title)

@section('content')

<div class="mb-4">
    <a href="{{route('tasks.index')}}" 
                class="link"><- Go back to task list</a>
</div>

<p class="mb-4 text-slate-700" >{{ $task ->description}} </p>

@if ($task -> long_description)
<p class="mb-4 text-slate-700"> {{ $task ->long_description}} </p>
    
@endif
<p class="mb-4 text-sm text-slate-500">
Created: {{ $task ->created_at ->diffForHumans()}} | Updated: {{ $task ->updated_at->diffForHumans()}}</p>

<p class="mb-4 ">
@if ($task ->completed)
   <span class="font-medium text-green-500">Task is completed</span> 
@else
    <span class="font-medium text-red-500">Task is not completed</span> 
@endif
</p>

<div class="flex gap-2">
    <!-- <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">Edit task</a>  mozna nawet prościej-->
    <a href="{{ route('tasks.edit', [$task]) }}" 
    class="btn">Edit task</a>

    <form method="POST" action=" {{ route('tasks.toggle-complete',  ['task'=> $task]) }}">
        @csrf
        @method('PUT')
        <button class="btn" type="submit"> {{ $task->completed? 'Not completed' : 'Completed'}}</button>
    </form>

    <!-- <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST"> mozna nawet prościej-->
    <form action="{{ route('tasks.destroy', [ $task]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn" type="submit">Delete task</button>
    </form>

</div>

@endsection