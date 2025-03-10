<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttributeValueController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = AttributeValue::with('attribute');

        if (!$user->isAdmin()) {
            $projectIds = $user->projects()->pluck('projects.id')->toArray();
            $query->whereIn('entity_id', $projectIds);

            if ($request->has('entity_id')) {
                $requestedEntityId = $request->entity_id;
                if (!in_array($requestedEntityId, $projectIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access to project'
                    ], 403);
                }
                $query->where('entity_id', $requestedEntityId);
            }
        } else {
            if ($request->has('entity_id')) {
                $query->where('entity_id', $request->entity_id);
            }
        }

        $this->applyCommonFilters($query, $request);

        $this->applySorting($query, $request);

        $attributeValues = $query->paginate($request->input('paginate', 10));

        return response()->json([
            'success' => true,
            'data' => $attributeValues->items(),
            'pagination' => [
                'current_page' => $attributeValues->currentPage(),
                'total_pages' => $attributeValues->lastPage(),
                'per_page' => $attributeValues->perPage(),
                'total_records' => $attributeValues->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'entity_id' => 'required|integer|min:1',
            'value' => 'required'
        ]);
        //If the system is complex, I believe we will have to validate the value with the attribute_type to
        //ensure values match their attribute type and avoid data inconsistency on database.
        $projectCheck = $this->checkProjectExists($validated['entity_id']);
        if ($projectCheck) {
            return $projectCheck;
        }
        $permissionCheck = $this->checkProjectPermission($validated['entity_id']);
        if ($permissionCheck) {
            return $permissionCheck;
        }


        $attributeValue = AttributeValue::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Attribute value created successfully',
            'data' => $attributeValue
        ], 201);
    }

    public function show(AttributeValue $attributeValue)
    {
        $attributeValue->load(['attribute', 'project']);

        return response()->json([
            'success' => true,
            'data' => $attributeValue
        ]);
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $validated = $request->validate([
            'attribute_id' => 'sometimes|required|exists:attributes,id',
            'entity_id' => 'sometimes|required|integer|min:1',
            'value' => 'sometimes|required'
        ]);
        $permissionCheck = $this->checkProjectPermission($validated['entity_id'] ?? $attributeValue->entity_id);
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $permissionCheck = $this->checkProjectPermission($validated['entity_id'] ?? $attributeValue->entity_id);
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $attributeValue->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Attribute value updated successfully',
            'data' => $attributeValue
        ]);
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $permissionCheck = $this->checkProjectPermission($attributeValue->entity_id);
        if ($permissionCheck) {
            return $permissionCheck;
        }
        $attributeValue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute value deleted successfully'
        ]);
    }

    private function checkProjectExists($projectId)
    {
        $project = Project::find($projectId);
        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project with the specified ID does not exist'
            ], 404);
        }

        return null;
    }
    private function checkProjectPermission($projectId)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->projects()->where('projects.id', $projectId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to modify attributes for this project'
            ], 403);
        }

        return null;
    }

    protected function applyCommonFilters($query, $request)
    {
        if ($request->has('value')) {
            $operator = $request->boolean('exact_match') ? '=' : 'LIKE';
            $value = $request->boolean('exact_match') ? $request->value : "%{$request->value}%";
            $query->where('value', $operator, $value);
        }

        if ($request->has('attribute_id')) {
            $query->where('attribute_id', $request->attribute_id);
        }

        if ($request->has('attribute_name')) {
            $query->whereHas(
                'attribute',
                fn($q) =>
                $q->where('name', 'LIKE', "%{$request->attribute_name}%")
            );
        }

        if ($request->has('attribute_type')) {
            $query->whereHas(
                'attribute',
                fn($q) =>
                $q->where('type', $request->attribute_type)
            );
        }

        if ($request->has('created_from')) {
            $query->where('created_at', '>=', $request->created_from);
        }

        if ($request->has('created_to')) {
            $query->where('created_at', '<=', $request->created_to);
        }
    }

    protected function applySorting($query, $request)
    {
        $validSorts = ['attribute_id', 'entity_id', 'value', 'created_at', 'updated_at'];
        $sortBy = in_array($request->sort_by, $validSorts)
            ? $request->sort_by
            : 'created_at';

        $sortDir = strtolower($request->sort_dir) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDir);
    }
}
