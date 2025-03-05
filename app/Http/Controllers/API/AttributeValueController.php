<?php

namespace App\Http\Controllers\API;

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
            'value' => 'required|string'
        ]);
        //If the system is complex, I believe we will have to validate the value with the attribute_type to
        //ensure values match their attribute type and avoid data inconsistency on database.
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->projects()->where('projects.id', $validated['entity_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to add attributes to this project'
            ], 403);
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
            'value' => 'sometimes|required|string'
        ]);

        $attributeValue->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Attribute value updated successfully',
            'data' => $attributeValue
        ]);
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute value deleted successfully'
        ]);
    }
}
