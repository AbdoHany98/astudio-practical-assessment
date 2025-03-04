<?php

namespace App\Http\Controllers\API;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return response()->json([
            'success' => true,
            'data' => $attributes
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['text', 'date', 'number', 'select'])]
        ]);
        $attribute = Attribute::create([
            'name' => $request->name,
            'type' => $request->type
        ]);
        return response()->json([
            'success' => true,
            'data' => $attribute
        ], 201);
    }

    public function show(Attribute $attribute)
    {
        $attribute->load('values');
        
        return response()->json([
            'success' => true,
            'data' => $attribute
        ]);
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => ['sometimes', 'required', Rule::in(['text', 'date', 'number', 'select'])]
        ]);

        $attribute->update([
            'name' => $request->name ?? $attribute->name,
            'type' => $request->type ?? $attribute->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attribute updated successfully',
            'data' => $attribute
        ], Response::HTTP_OK);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute deleted successfully'
        ]);
    }
}
