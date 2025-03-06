<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['attributeValues.attribute', 'users']);
        
        if ($request->has('filters')) {
            $this->applyFilters($query, $request->input('filters'));
        }
        $paginate = $request->input('paginate', 10);

        return ProjectResource::collection($query->paginate($paginate));
    }

    private function applyFilters($query, $filters)
    {
        foreach ($filters as $rawKey => $value) {
            $parts = explode(':', $rawKey);
            $key = $parts[0];
            $operator = count($parts) > 1 ? $parts[1] : '=';

            if ($operator === 'like' || $operator === 'LIKE') {
                $operator = 'LIKE';
                $value = "%$value%";
            }

            if (in_array($key, ['name', 'status'])) {
                $query->where($key, $operator, $value);
            } else {
                $query->whereHas('attributeValues', function ($q) use ($key, $operator, $value) {
                    $q->whereHas('attribute', function ($q) use ($key) {
                        $q->where('name', $key);
                    })->where('value', $operator, $value);
                });
            }
        }
    }

    public function store(CreateProjectRequest $request)
    {
        try {
            $validated = $request->validated();
            
            DB::beginTransaction();
            
            $project = Project::create($validated);
            
            if ($request->has('users')) {
                $project->users()->sync($request->input('users', []));
            }
            
            if ($request->has('attributes')) {
                $this->syncAttributes($project, $request->input('attributes', []));
            }
            
            DB::commit();
            
            return new ProjectResource($project->load(['attributeValues.attribute', 'users']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create project',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Project $project)
    {
        $project->load(['attributeValues.attribute', 'users']);
            
        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        try {            
            DB::beginTransaction();
            
            if ($request->has('name')) {
                $project->name = $request->input('name');
            }
            
            if ($request->has('status')) {
                $project->status = $request->input('status');
            }
            
            $project->save();
            
            if ($request->has('users')) {
                $project->users()->sync($request->input('users', []));
            }
            
            if ($request->has('attributes')) {
                $this->syncAttributes($project, $request->input('attributes', []));
            }
            
            DB::commit();
            
            return new ProjectResource($project->load(['attributeValues.attribute', 'users']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update project',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Project $project)
    {
        try {            
            DB::beginTransaction();

            $project->attributeValues()->delete();
            $project->users()->detach();
            $project->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Project deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete project',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function syncAttributes(Project $project, array $attributes)
    {
        foreach ($attributes as $attribute) {
            AttributeValue::updateOrCreate(
                [
                    'attribute_id' => $attribute['attribute_id'],
                    'entity_id' => $project->id,
                ],
                ['value' => $attribute['value']]
            );
        }
    }
}

