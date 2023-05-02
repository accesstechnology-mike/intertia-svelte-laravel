<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $clients = Client::where('user_id', $user->id)
            ->where('client_status', '!=', 'inactive')
            ->orderBy('client_status')
            ->get();

        return response()->json($clients);
    }

    public function updateStatus(Request $request, Client $client)
    {
        $request->validate([
            'client_status' => 'required|in:newClient,assessmentScheduled,initialAssessment,awaiting,setup,ongoing,review,yearly,inactive',
        ]);

        $client->client_status = $request->client_status;
        $client->save();

        return Inertia::render('Dashboard');
    }
}
