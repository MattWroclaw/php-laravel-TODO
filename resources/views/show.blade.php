@extends('layouts.app')

@section('title', $task ->title)

@section('content')

<p>{{ $task ->description}} </p>

@if ($task -> long_description)
<h2> {{ $task ->long_description}} </h2>
    
@endif
<p>{{ $task ->created_at}} </p>
<p>{{ $task ->updated_at}} </p>

@if ($task ->completed)
    <p>Task is completed</p>
@else
    <p>Task is not completed</p>
@endif


<div>
    <!-- <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">Edit task</a>  mozna nawet prościej-->
    <a href="{{ route('tasks.edit', [$task]) }}">Edit task</a>
</div>

<div>
    <form method="POST" action=" {{ route('tasks.toggle-complete',  ['task'=> $task]) }}">
        @csrf
        @method('PUT')
        <button type="submit"> {{ $task->completed? 'Not completed' : 'Completed'}}</button>
    </form>
</div>

<div>
    <!-- <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST"> mozna nawet prościej-->
    <form action="{{ route('tasks.destroy', [ $task]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete task</button>
    </form>

</div>

@endsection