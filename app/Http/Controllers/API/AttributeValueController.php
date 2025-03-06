<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->get();

        return response()->json([
            'success' => true,
            'data' => $attributeValues
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
}
