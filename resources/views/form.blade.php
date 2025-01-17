@extends('layouts.app')
@section('title', isset($task) ? 'Edit Task':'Add Task') 

<!-- adding custom styles -->
<!-- @section('styles')
    <style>
        .error-messsage {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection -->

@section('content')
<!-- {{ $errors}} -->
<form method="POST" action="{{ isset($task) ? route('tasks.update' , ['task' => $task->id]) : route('tasks.store')  }}">
    @csrf

    @isset($task)
        @method("PUT")
    @endisset


    <div class="mb-4">
        <label for="title">
            Title
        </label>
        <input text="text" name="title" id="title" 
       
            @class([ 'border-red-500' => $errors->has('title') ])   
            
            value="{{ $task->title ?? old('title') }}"  />    
            @error('title')
            <p class="error"> {{ $message }} </p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="description">
            Description
        </label>
        <textarea @class([ 'border-red-500' => $errors->has('description') ]) 
        name="description" id="description" rows="5"> 
            {{ $task->description ?? old('description')}} 
        </textarea>
        @error('description')
            <p class="error"> {{ $message }} </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="long_description">
            Long description
        </label>
        <textarea @class([ 'border-red-500' => $errors->has('long_description') ]) 
        name="long_description" id="long_description" rows="10"> 
            {{ $task ->long_description ?? old('long_description')}} 
        </textarea>
        @error('long_description')
            <p class="error"> {{ $message }} </p>
        @enderror
    </div>

    <div class="flex gap-2 items-center">
        <button class="btn" type="submit">
            @isset($task)
                Edit Task 
            @else
                Add Task               
            @endisset

        </button>
        <a href="{{route('tasks.index')}}">Cancel</a>
    </div>

</form>


@endsection