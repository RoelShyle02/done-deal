<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Planner;
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

    public function getTasks(Request $request)
    {
        $user_id = auth()->user()->id;
        $planner_id = $request->planner_id;
        $tasks = Planner::find($planner_id)->tasks;

        return response()->json(['tasks' => $tasks], 200);
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
