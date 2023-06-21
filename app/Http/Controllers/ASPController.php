<?php

namespace App\Http\Controllers;

use App\Models\ASP;
use App\Models\Client;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ASPController extends Controller
{
    public function index()
    {
        $asp_clients = ASP::with('user')->whereHas('client', function ($query) {
            $query->where('client_status', '!=', 'inactive');
        })->get();

        return Inertia::render('ASP/Index', ['clients' => $asp_clients->toArray()]);
    }

    public function create()
    {
        $clients = Client::select('id', 'name')->where('client_status', '!=', 'inactive')->orderBy('name', 'asc')->get();
        return Inertia::render('ASP/Create', ['clients' => $clients->toArray()]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|integer',
            'amount' => 'required|numeric',
            'type' => 'required|string|in:Standard,DWB',
            'start_date' => 'required|date',
        ]);

        $asp = new ASP([
            'client_id' => $validatedData['client_id'],
            'amount' => $validatedData['amount'],
            'type' => $validatedData['type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => Carbon::parse($validatedData['start_date'])->addYear()->subDay(),
        ]);

        $asp->save();

        return redirect()->route('asp.index')->with('success', 'ASP entry created successfully');
    }


    public function edit(Client $entry)
    {
        // Render edit form
        return Inertia::render('ASP/Edit', ['entry' => $entry]);
    }

    public function update(Request $request, Client $entry)
    {
        // Update the entry
    }

    public function destroy(Client $entry)
    {
        // Delete the entry
    }
}
