<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests;
use Laracasts\Flash\Flash;
use App\Repositories\TaskRepository;
use App\Task;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks){
    	$this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index(Request $request){
    	$tasks = $request->user()->tasks()->get();
    	return view('tasks.index',[
    			'tasks' => $this->tasks->forUser($request->user()),
                //'tasks' => $tasks,
    		]);
    	//return view('tasks.index');
    }

    public function store(CreateTaskRequest $request){
    	$request->user()->tasks()->create([
    			'name' => $request->name,
    		]);
    	Flash::success('New task created.');
    	// Note :: $request->user() = In this case, the create method will automatically set the user_id property of the given task to the ID of the currently authenticated user, which we are accessing using $request->user(). source : https://laravel.com/docs/5.2/quickstart-intermediate#database-migrations
    	return redirect('/tasks');
    }

    /**
 * Destroy the given task.
 *
 * @param  Request  $request
 * @param  Task  $task
 * @return Response

 Since the {task} variable in our route matches the $task variable defined in our controller method, Laravel's implicit model binding will automatically inject the corresponding Task model instance.
 */

    public function destroy(Request $request, Task $task){
        $this->authorize('destroy',$task);

        $task->delete();

        return redirect('/tasks');
    }
}
