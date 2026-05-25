<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    public function index()
    {
        // Getting events data
        $url = env('API_URL').'events';

        $response = Http::get($url);

        // Checking response
        if(!$response->succesful()) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ]);
        }->withInput();

        // Passing data to view
        $events = $response->json()['data']['items'];

        return view('catalog', compact('events'));
    }

    public function searchEvent(Request $request) {
        // Getting event name
        $data = $request->validate([ "eventName" => "required" ])
        $eventName = $data['eventName'];

        // Making request
        $url = env('API_URL').'events';

        $response = Http::get($url);

        // Checking response
        if($response->status() == 500) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ])->withInput();
        }
        
        // Filtering by event name
        $events = $response->json()['data']['items']

        $filteredEvents = $events->filter(fn($event) => Str::lower($event->name) == Str::lower($eventName));

        // Passing data to view
        return view('catalog', compact('filteredEvents'));
    }

    public function filterEvents(Request $request) {
        // Making request
        $url = env('API_URL').'events'

        $response = Http:get($url)
        
        // Getting filters
        
    }
}
