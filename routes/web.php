<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;




class Task
{
  public function __construct(
    public int $id,
    public string $title,
    public string $description,
    public ?string $long_description,
    public bool $completed,
    public string $created_at,
    public string $updated_at
  ) {
  }
}

$tasks = [
  new Task(
    1,
    'Buy groceries',
    'Task 1 description',
    'Task 1 long description',
    false,
    '2023-03-01 12:00:00',
    '2023-03-01 12:00:00'
  ),
  new Task(
    2,
    'Sell old stuff',
    'Task 2 description',
    null,
    false,
    '2023-03-02 12:00:00',
    '2023-03-02 12:00:00'
  ),
  new Task(
    3,
    'Learn programming',
    'Task 3 description',
    'Task 3 long description',
    true,
    '2023-03-03 12:00:00',
    '2023-03-03 12:00:00'
  ),
  new Task(
    4,
    'Take dogs for a walk',
    'Task 4 description',
    null,
    false,
    '2023-03-04 12:00:00',
    '2023-03-04 12:00:00'
  ),
];


Route::get('/' , function () {
    return redirect() ->route('tasks.index');
});


Route::get('/tasks', function ()  {
    // return view('welcome');
    return view('index' ,[
        // 'tasks' => \App\Models\Task::all()
        'tasks' => \App\Models\Task::latest()->get()
    ]);
})->name('tasks.index');


Route::view('/tasks/create', 'create')->name('tasks.create');


Route::get('/tasks/{id}' , function ($id)  {
//  refer to the Task Model class , so there is FQPath. From where find() method is? "There is one" :)
    $task = \App\Models\Task::findOrFail($id);

    return view('show', ['task' => $task]);
})->name('task.show');


Route::post('tasks', function(Request $request){
  // dd('We have reached the store route' , $request->all());
  $data = $request->validate([
    'title' =>'required|max:255',
    'description' =>'required',
    'long_description' =>'required'
  ]);
  $task = new \App\Models\Task();
  $task->title = $data['title'];
  $task->description = $data['description'];
  $task->long_description = $data['long_description'];
  $task->save();

  return redirect()->route('task.show', ['id' => $task->id]);

})->name('tasks.store');




// Gdy braliśmy taska z przykładowej klasy Task
// Route::get('/tasks/{id}' , function ($id) use ($tasks) {
//   $task = collect($tasks)->firstWhere('id', $id);

//   if(!$task){
//       abort(Response::HTTP_NOT_FOUND);
//   }

//   return view('show', ['task' => $task]);
// })->name('task.show');

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