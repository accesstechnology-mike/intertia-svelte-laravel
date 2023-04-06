<?php

namespace App\Http\Controllers\Api;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::all();
        return response()->json($holidays);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date|unique:holidays,date',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $holiday = Holiday::create($request->all());
        return response()->json($holiday, 201);
    }

    public function show(Holiday $holiday)
    {
        return response()->json($holiday);
    }

    public function update(Request $request, Holiday $holiday)
    {
        $this->validate($request, [
            'date' => 'sometimes|date|unique:holidays,date,' . $holiday->id,
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:255',
        ]);

        $holiday->update($request->all());
        return response()->json($holiday);
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return response()->json(null, 204);
    }
}
