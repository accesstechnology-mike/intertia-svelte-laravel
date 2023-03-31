<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class DashboardController extends Controller
{
    //dashboard route

    public function dashboard()
    {
        //     // Define custom order for client_status
        //     $customOrder = "
        //     FIELD(client_status, 
        //         'newClient', 
        //         'assessmentScheduled', 
        //         'initialAssessment', 
        //         'awaiting', 
        //         'setup', 
        //         'ongoing', 
        //         'review', 
        //         'yearly'
        //     )
        // ";

        // Get clients from database where user_id = current user and client_status is not "inactive"
        $clients = Client::where('user_id', auth()->user()->id)
            ->where('client_status', '!=', 'inactive')
            // ->orderByRaw($customOrder)
            ->get();

        // Return dashboard view with clients
        return inertia('Dashboard', [
            'clients' => $clients,
        ]);
    }
}
