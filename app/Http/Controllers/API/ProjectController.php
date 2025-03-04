<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Start with base project query
    //     $query = Project::query();

    //     // Process filters
    //     $filters = $request->input('filters', []);

    //     // Handle regular model attributes first
    //     $regularAttributes = ['name', 'status']; // Add other direct model attributes as needed
    //     foreach ($regularAttributes as $attribute) {
    //         if (isset($filters[$attribute])) {
    //             $this->applyFilter($query, $attribute, $filters[$attribute]);
    //         }
    //     }

    //     // Handle dynamic EAV attributes
    //     $this->applyEavFilters($query, $filters);

    //     // Optional: Add sorting, pagination, etc.
    //     $projects = $query->with('attributeValues.attribute')->paginate(10);

    //     return response()->json($projects);
    // }

    // public function store(CreateProjectRequest $request)
    // {
    //     try {
    //         $validatedData = $request->validated();
    //         DB::beginTransaction();
    //         $project = Project::create($validatedData);

    //         if ($request->has('attributes')) {
    //             foreach ($request->attributes as $attr) {
    //                 AttributeValue::updateOrCreate(
    //                     ['attribute_id' => $attr['attribute_id'], 'entity_id' => $project->id],
    //                     ['value' => $attr['value']]
    //                 );
    //             }
    //         }

    //         return response()->json($project->load('attributeValues'), 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'message' => 'Failed to create project',
    //             'error' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }

    // }

    // /**
    //  * Apply filter to the query based on operator
    //  * 
    //  * @param Builder $query
    //  * @param string $field
    //  * @param mixed $value
    //  */
    // protected function applyFilter(Builder $query, string $field, $value)
    // {
    //     // Parse the filter value which can be a simple value or an array with operator
    //     if (is_array($value)) {
    //         $operator = $value['operator'] ?? '=';
    //         $filterValue = $value['value'];
    //     } else {
    //         $operator = '=';
    //         $filterValue = $value;
    //     }

    //     // Supported operators
    //     $allowedOperators = ['=', '>', '<', 'LIKE'];
    //     $operator = in_array(strtoupper($operator), $allowedOperators) ? $operator : '=';

    //     // Apply the filter
    //     if (strtoupper($operator) === 'LIKE') {
    //         $query->where($field, 'LIKE', "%{$filterValue}%");
    //     } else {
    //         $query->where($field, $operator, $filterValue);
    //     }
    // }

    // /**
    //  * Apply EAV filters to the query
    //  * 
    //  * @param Builder $query
    //  * @param array $filters
    //  */
    // protected function applyEavFilters(Builder $query, array $filters)
    // {
    //     // Filter out any regular attributes
    //     $regularAttributes = ['name', 'status']; // Match the list from applyFilter method
    //     $eavFilters = array_diff_key($filters, array_flip($regularAttributes));

    //     // If no EAV filters, return
    //     if (empty($eavFilters)) {
    //         return;
    //     }

    //     // Apply EAV filters
    //     $query->whereHas('attributeValues.attribute', function ($subQuery) use ($eavFilters) {
    //         foreach ($eavFilters as $attributeName => $value) {
    //             $subQuery->where('name', $attributeName)
    //                 ->whereHas('values', function ($valueQuery) use ($value) {
    //                     // Handle both simple and complex filter values
    //                     if (is_array($value)) {
    //                         $operator = $value['operator'] ?? '=';
    //                         $filterValue = $value['value'];
    //                     } else {
    //                         $operator = '=';
    //                         $filterValue = $value;
    //                     }

    //                     // Supported operators
    //                     $allowedOperators = ['=', '>', '<', 'LIKE'];
    //                     $operator = in_array(strtoupper($operator), $allowedOperators) ? $operator : '=';

    //                     // Apply the filter
    //                     if (strtoupper($operator) === 'LIKE') {
    //                         $valueQuery->where('value', 'LIKE', "%{$filterValue}%");
    //                     } else {
    //                         $valueQuery->where('value', $operator, $filterValue);
    //                     }
    //                 });
    //         }
    //     });
    // }

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

