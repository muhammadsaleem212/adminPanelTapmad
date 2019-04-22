<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = request()->user()->tasks;
 
        return response()->json([
            'tasks' => $tasks,
        ], 200);
    }
}
