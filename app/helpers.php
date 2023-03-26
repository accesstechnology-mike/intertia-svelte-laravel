<?php

//get rates from role
function getRatesFromRole($role) {
    if (($role=='Technician') || ($role == 'Assistant')) {
        $travelRate = env('ASSTECH_TRAVEL_RATE');
        $rate = env('ASSTECH_RATE');
    } else {
        $travelRate = env('TRAVEL_RATE');
        $rate = env('RATE');
    }

    //return object
    return (object) [
        'travelRate' => $travelRate,
        'rate' => $rate,
    ];
    
}