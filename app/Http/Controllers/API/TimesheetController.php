<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $query = Timesheet::query();
        
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        
        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        $paginate = $request->input('paginate', 10);
        $timesheets = $query->with(['user', 'project'])->paginate($paginate);
        
        return response()->json([
            'success' => true,
            'data' => $timesheets,
            'pagination' => [
                    'current_page' => $timesheets->currentPage(),
                    'total_pages' => $timesheets->lastPage(),
                    'per_page' => $timesheets->perPage(),
                    'total_records' => $timesheets->total(),
                ],
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0.1|max:24',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $project = Project::findOrFail($request->project_id);
        $userId = Auth::user()->isAdmin() ? $request->user_id : Auth::id();
        
        if (!$project->users()->where('users.id', $userId)->exists()) {
            return response()->json([
                'message' => 'User is not assigned to this project'
            ], Response::HTTP_FORBIDDEN);
        }

        $timesheet = Timesheet::create([
            'name' => $request->task_name,
            'date' => $request->date,
            'hours' => $request->hours,
            'project_id' => $request->project_id,
            'user_id' => $userId,
        ]);

        return response()->json([
            'message' => 'Timesheet created successfully',
            'data' => $timesheet
        ], Response::HTTP_CREATED);
    }

    public function show(Timesheet $timesheet)
    {
        if ($timesheet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'message' => 'You are not authorized to view this timesheet'
            ], Response::HTTP_FORBIDDEN);
        }
        
        return response()->json(['data' => $timesheet->load(['user', 'project'])], Response::HTTP_OK);
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        if ($timesheet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'message' => 'You are not authorized to update this timesheet'
            ], Response::HTTP_FORBIDDEN);
        }
        
        $validator = Validator::make($request->all(), [
            'task_name' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'hours' => 'sometimes|required|numeric|min:0.1|max:24',
            'project_id' => 'sometimes|required|exists:projects,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        if ($request->has('project_id') && $request->project_id != $timesheet->project_id) {
            $project = Project::findOrFail($request->project_id);
            
            if (!$project->users()->where('users.id', $timesheet->user_id)->exists()) {
                return response()->json([
                    'message' => 'User is not assigned to the selected project'
                ], Response::HTTP_FORBIDDEN);
            }
        }

        if ($request->has('task_name')) {
            $timesheet->name = $request->task_name;
        }
        
        if ($request->has('date')) {
            $timesheet->date = $request->date;
        }
        
        if ($request->has('hours')) {
            $timesheet->hours = $request->hours;
        }
        
        if ($request->has('project_id')) {
            $timesheet->project_id = $request->project_id;
        }
        
        $timesheet->save();

        return response()->json([
            'message' => 'Timesheet updated successfully',
            'data' => $timesheet->load(['user', 'project'])
        ], Response::HTTP_OK);
    }

    public function destroy(Timesheet $timesheet)
    {
        if ($timesheet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'message' => 'You are not authorized to delete this timesheet'
            ], Response::HTTP_FORBIDDEN);
        }
        
        $timesheet->delete();
        
        return response()->json([
            'message' => 'Timesheet deleted successfully'
        ], Response::HTTP_OK);
    }
}