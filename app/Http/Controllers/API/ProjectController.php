<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

            // Check if this is a direct model attribute
            if (in_array($key, ['name', 'status'])) {
                $query->where($key, $operator, $value);
            } else {
                // This is a dynamic EAV attribute
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
            
            // Sync users if provided
            if ($request->has('users')) {
                $project->users()->sync($request->input('users', []));
            }
            
            // Sync attributes if provided
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

    public function show($id)
    {
        $project = Project::with(['attributeValues.attribute', 'users'])
            ->findOrFail($id);
            
        return new ProjectResource($project);
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            
            DB::beginTransaction();
            
            // Update basic fields
            if ($request->has('name')) {
                $project->name = $request->input('name');
            }
            
            if ($request->has('status')) {
                $project->status = $request->input('status');
            }
            
            $project->save();
            
            // Sync users if provided
            if ($request->has('users')) {
                $project->users()->sync($request->input('users', []));
            }
            
            // Sync attributes if provided
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

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            DB::beginTransaction();
            
            // Delete related attribute values
            $project->attributeValues()->delete();
            
            // Detach users
            $project->users()->detach();
            
            // Delete the project
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

