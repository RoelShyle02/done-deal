<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Planner;
use App\Models\Task;
use Illuminate\Support\Str;

class TaskController extends Controller
{

    // get planners 

    public function getPlanners()
    {
        $user_id = auth()->user()->id;
        $planners = Planner::where('created_by', $user_id)->get();


        return response()->json(['planners' => $planners], 200);
    }

    public function getDashboardPlanners()
    {
        $user_id = auth()->user()->id;
        $planners = Planner::where('created_by', $user_id)->get();
        $tasks = Task::where('created_by', $user_id)->get();
        $planner_tasks = [];
        foreach ($planners as $planner) {
            $planner_tasks[] = [
                'planner' => $planner,
                'tasks' => $tasks->where('planner_guid', $planner->guid)->values()->all()
            ];
        }
        return response()->json(['planner_tasks' => $planner_tasks], 200);
    }

    public function getTasks(Request $request)
    {
        $planner_id = $request->planner_id;

        if (!$planner_id) {
            return response()->json(['error' => 'Planner ID is required'], 400);
        }

        // Find the planner by ID
        $planner = Planner::where('guid', $planner_id)->first();

        if (!$planner) {
            // Return null or an empty response if planner is not found
            return response()->json(['tasks' => null], 200);
        }

        // Get the tasks for the given planner_id
        $tasks = Task::where('planner_guid', $planner_id)->get();

        return response()->json(['tasks' => $tasks], 200);
    }

    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'planner_guid' => 'required',
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'priority_id' => 'required',
            'status_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user_id = auth()->user()->id;
        $planner_guid = $request->planner_guid;
        $title = $request->title;
        $description = $request->description;
        $due_date = $request->due_date;
        $priority_id = $request->priority_id;
        $status_id = $request->status_id;
        $created_by = $user_id;
        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->due_date = $due_date;
        $task->priority_id = $priority_id;
        $task->status_id = $status_id;
        $task->planner_guid = $planner_guid;
        $task->created_by = $created_by;
        $task->save();
        return response()->json(['task' => $task], 200);
    }


    public function updateTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'priority_id' => 'required',
            'status_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $task = Task::find($request->id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->priority_id = $request->priority_id;
        $task->status_id = $request->status_id;

        // Set completed_at timestamp if status is completed (status_id = 3)
        if ($request->status_id == 3) {
            $task->completed_at = now();
        } else {
            $task->completed_at = null;
        }

        $task->save();

        return response()->json(['task' => $task], 200);
    }
    

    public function deletePlanner(Request $request){

        $id = (int) $request->id;


        //delete it's tasks 

        $guid = Planner::where('id', $id)->first()->guid;

        Task::where("planner_guid" , $guid)->delete();

        $deleted = Planner::where('id', $id)->delete();

        if($deleted){
            return response()->json(['message' => 'ok'], 200);
        }
        else {
            return response()->json(['error' =>'Some error occurred'], 401);
 
        }
    }



    public function createPlanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user_id = auth()->user()->id;

        //create a slug based on the name 
        $slug = str_replace(' ', '-', $request->name);


        //make it only lowercase
        $slug = strtolower($slug);

        $guid = Str::uuid();

        $planner = new Planner();
        $planner->guid = $guid;

        $planner->name = $request->name;
        $planner->slug = $slug;
        $planner->created_by = $user_id;
        $planner->save();

        return response()->json(['planner' => $planner], 200);
    }
}
