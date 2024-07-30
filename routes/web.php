<?php

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;




// class Task
// {
//   public function __construct(
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//   ) {
//   }
// }

// $tasks = [
//   new Task(
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//   ),
//   new Task(
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//   ),
//   new Task(
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//   ),
//   new Task(
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//   ),
// ];


Route::get('/' , function () {
    return redirect() ->route('tasks.index');
});


Route::get('/tasks', function ()  {
    // return view('welcome');
    return view('index' ,[
        // 'tasks' => \App\Models\Task::all()
        'tasks' => \App\Models\Task::latest()->paginate(10)
    ]);
})->name('tasks.index');


Route::view('/tasks/create', 'create')->name('tasks.create');

/* This is OK, but can be done better  */
// Route::get('/tasks/{id}/edit' , function ($id)  {
//   //  refer to the Task Model class , so there is FQPath. From where find() method is? "There is one" :)
//       $task = \App\Models\Task::findOrFail($id);
  
//       return view('edit', ['task' => $task]);
//   })->name('task.edit');


// This is doing the same what below but is preffered
Route::get('/tasks/{task}/edit', function(Task $task){
  // default task= task_id; Configuration in Task (Model) clas via getRouteKeyName() function
  return view('edit' , [
    'task' => $task
  ]);
})->name('tasks.edit');





/* Old way */
// Route::get('/tasks/{id}' , function ($id)  {
// //  refer to the Task Model class , so there is FQPath. From where find() method is? "There is one" :)
//     $task = \App\Models\Task::findOrFail($id);

//     return view('show', ['task' => $task]);
// })->name('tasks.show');

Route::get('/tasks/{task}', function (Task $task){
  return view('show' , [
    'task' => $task
  ]);
})->name('tasks.show');

Route::post('/tasks', function(TaskRequest $request){
  // dd('We have reached the store route' , $request->all());

  // if we use ::create() then we don t need the below
  // $data = $request->validated();
  // $task = new \App\Models\Task();
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save();

  $task = Task::create($request->validated());

  return redirect()->route('tasks.show', ['task' => $task->id])
    ->with('success', 'Task created sucessfully!');

})->name('tasks.store');

Route::put('/tasks/{task}', function(Task $task, TaskRequest $request){
  // dd('We have reached the store route' , $request->all());
// to już niepotrzebne bo mamy TaskRequest
  // $data = $request->validate([
  //   'title' =>'required|max:255',
  //   'description' =>'required',
  //   'long_description' =>'required'
  // ]);
  
  // $data = $request -> validated();
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save(); // this will make update, not create a new one

  $task->update($request->validated());


  return redirect()->route('tasks.show', ['task' => $task->id])
    ->with('success', 'Task updated sucessfully!');

})->name('tasks.update');


Route::delete('/tasks/{task}', function(Task $task){
  $task->delete();

  return redirect()->route('tasks.index')
  ->with('success','Task deleted successfully!');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function (Task $task) {
  $task->toggleComplete();
  // return "successssss";
  return redirect()->back()->with('success', 'Task status changed successfully!');

})->name('tasks.toggle-complete');

// Gdy braliśmy taska z przykładowej klasy Task
// Route::get('/tasks/{id}' , function ($id) use ($tasks) {
//   $task = collect($tasks)->firstWhere('id', $id);

//   if(!$task){
//       abort(Response::HTTP_NOT_FOUND);
//   }

//   return view('show', ['task' => $task]);
// })->name('tasks.show');

// Route::get('/tasks', function () use ($tasks) {
//   // return view('welcome');
//   return view('index' ,[
//       'tasks' => $tasks
//   ]);
// })->name('tasks.index');

// Route::get('/test1', function () {
//     // return view('welcome');
//     return "Hello test100";
// })->name('test100');

// Route::get('/xxx', function(){
//   return redirect('/');
// })->name('hello_basic');

// Route::get('/yyy', function(){
//     return redirect()->route('home');
// })->name('polish_hello');

// Route::get('/greet/{name}' , function($name){
//     return 'Hello '.$name .'!!!';
// });

Route::fallback(function(){
    return 'Sorry maaaan...., the page you are looking for could not be found.';
});