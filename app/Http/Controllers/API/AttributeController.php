<?php

namespace App\Http\Controllers\API;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $query = Attribute::query();
        
        // Filter by name
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        
        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by created_at date range
        if ($request->has('created_from')) {
            $query->where('created_at', '>=', $request->created_from);
        }
        
        if ($request->has('created_to')) {
            $query->where('created_at', '<=', $request->created_to);
        }
        
        // Add sorting capability
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        
        if (in_array($sortBy, ['name', 'type', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }
        $paginate = $request->input('paginate', 10);
        $attributes = $query->paginate($paginate);
        return response()->json([
            'success' => true,
            'data' => $attributes,
            'pagination' => [
                    'current_page' => $attributes->currentPage(),
                    'total_pages' => $attributes->lastPage(),
                    'per_page' => $attributes->perPage(),
                    'total_records' => $attributes->total(),
                ],
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
        $attribute->values()->delete();

        $attribute->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute deleted successfully'
        ]);
    }
}
