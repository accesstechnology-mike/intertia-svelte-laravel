<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ASPController extends Controller
{
    public function index()
    {
        // Fetch all active clients
        $clients = Client::with('user')->where('client_status', '!=', 'inactive')->get();
        return Inertia::render('ASP/Index', ['clients' => $clients]);
    }

    public function create()
    {
        // Render create form
        return Inertia::render('ASP/Create');
    }

    public function store(Request $request)
    {
        // Store the new entry
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
