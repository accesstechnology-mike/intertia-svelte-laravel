<?php

namespace App\Http\Controllers\Api;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        // Apply any necessary filters, such as user_id or status
        $leaveRequests = LeaveRequest::query();

        // Paginate the results
        return $leaveRequests->paginate(15);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Implement your business logic for creating a leave request here

        $leaveRequest = LeaveRequest::create($request->all());
        return response()->json($leaveRequest, 201);
    }

    public function show(LeaveRequest $leaveRequest)
    {
        return response()->json($leaveRequest);
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $this->validate($request, [
            'leave_type_id' => 'sometimes|exists:leave_types,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'duration' => 'sometimes|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Implement your business logic for updating a leave request here

        $leaveRequest->update($request->all());
        return response()->json($leaveRequest);
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return response()->json(null, 204);
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        // Implement your business logic for approving a leave request here
        // For example, set the 'status' field to 'approved' and set the 'approver_id'

        $leaveRequest->update([
            'status' => 'approved',
            'approver_id' => auth()->user()->id,
        ]);

        return response()->json($leaveRequest);
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $this->validate($request, [
            'reason' => 'required|string',
        ]);

        // Implement your business logic for rejecting a leave request here
        // For example, set the 'status' field to 'rejected' and set the 'approver_id', and store the reason in the 'notes'

        $leaveRequest->update([
            'status' => 'rejected',
            'approver_id' => auth()->user()->id,
            'notes' => $request->reason,
        ]);

        return response()->json($leaveRequest);
    }
}