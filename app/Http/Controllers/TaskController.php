<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskCreated;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */


        public function filter(Request $request)
        {
            $tasks = Task::query()
                ->with(['user','status'])
                ->when($request->status_id, fn($q) => $q->where('status_id', $request->status_id))
                ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
                ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%")
                                                    ->orWhere('description', 'like', "%{$request->search}%"))
                ->get();

            return response()->json(['tasks' => $tasks]);
        }
    

    public function index()
    {
        //
        $statuses = Status::all();
        $tasks = Task::orderBy('id','desc')->paginate(5);
        return response()->view('cms.tasks.index', compact('tasks','statuses'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = Status::all(); 
        return response()->view('cms.tasks.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $validator = Validator($request->all(), []);

        if (!$validator->fails()) {
            $task = new Task();
            $task->title = $request->get('title');
            $task->description = $request->get('description');
            $task->priority = $request->get('priority');
            $task->due_date = $request->get('due_date');
            $task->user_id = $request->user()->id;
            $task->status_id = $request->get('status_id');

            $isSaved = $task->save();

            if ($isSaved) {
                $user = User::find(1);
                // foreach($users as $user){
                //     $user->notify(new TaskCreated($task));
                // }
                 $user->notify(new TaskCreated($task));
                return response()->json(['icon' => 'success', 'title' => 'Add Successfully'], $isSaved ? 201 : 400);

            } else {
                $request->session()->flash('status', 'alert-danger');
            }

        } else {

            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status = Status::all(); 
        $task = Task::findOrFail($id);
        return response()->view('cms.tasks.edit' , compact('task','status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), []);

        if (!$validator->fails()) {
            $task = Task::findOrFail($id);
            $task->title = $request->get('title');
            $task->description = $request->get('description');
            $task->priority = $request->get('priority');
            $task->due_date = $request->get('due_date');
            $task->user_id = $request->user()->id;
            $task->status_id = $request->get('status_id');

            $isSaved = $task->save();
            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'Updated Successfully'], $isSaved ? 201 : 400);
            } else {
                $request->session()->flash('status', 'alert-danger');
            }

        } else {

            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $isDeleted = Task::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted Successfully'], $isDeleted ? 200 : 400);
    }
}
