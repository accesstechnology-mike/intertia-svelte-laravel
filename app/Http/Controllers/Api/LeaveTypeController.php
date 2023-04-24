<?php

namespace App\Http\Controllers\Api;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return response()->json($leaveTypes);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7', // Assuming colors are stored as HEX values
        ]);

        $leaveType = LeaveType::create($request->all());
        return response()->json($leaveType, 201);
    }

    public function show(LeaveType $leaveType)
    {
        return response()->json($leaveType);
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7', // Assuming colors are stored as HEX values
        ]);

        $leaveType->update($request->all());
        return response()->json($leaveType);
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return response()->json(null, 204);
    }
}
