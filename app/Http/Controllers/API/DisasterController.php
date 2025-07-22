<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disaster;
use Illuminate\Support\Facades\Validator;

class DisasterController extends Controller
{
    // Fetch all disasters
    public function index()
    {
        $disasters = Disaster::all();
        return response()->json($disasters);
    }

    // Create a new disaster
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $disaster = Disaster::create($request->all());
        return response()->json($disaster, 201);
    }

    // Show a specific disaster
    public function show($id)
    {
        $disaster = Disaster::find($id);
        if (!$disaster) {
            return response()->json(['message' => 'Disaster not found'], 404);
        }
        return response()->json($disaster);
    }

    // Update a disaster
    public function update(Request $request, $id)
    {
        $disaster = Disaster::find($id);
        if (!$disaster) {
            return response()->json(['message' => 'Disaster not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $disaster->update($request->all());
        return response()->json($disaster);
    }

    // Delete a disaster
    public function destroy($id)
    {
        $disaster = Disaster::find($id);
        if (!$disaster) {
            return response()->json(['message' => 'Disaster not found'], 404);
        }

        $disaster->delete();
        return response()->json(['message' => 'Disaster deleted successfully'], 204);
    }
}
