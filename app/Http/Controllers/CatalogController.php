<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    private $url;

    public function __construct() {
        $this->url = config('api.url').'events';
    }

    public function index()
    {
        // Getting events data
        $response = Http::get($this->url);

        // Checking response
        if(!$response->successful()) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ])->withInput();
        }

        // Passing data to view
        $events = $response->json()['data']['items'];

        return view('catalog', compact('events'));
    }

    public function search(Request $request) {
        // PENDING THAT THE REQUEST IS NOT EMPTY

        // Getting event name
        $data = $request->validate([ "eventName" => "required" ]);
        $eventName = $data['eventName'];

        // Making request
        $response = Http::get($this->url);

        // Checking response
        if($response->status() == 500) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ])->withInput();
        }

        // Filtering by event name
        $events = collect($response->json()['data']['items']); // Converting into collection

        $filteredEvents = $events->filter(
            fn($event) =>
                Str::contains(Str::lower($event['name']), Str::lower($eventName))
        )->values();

        // Passing data to view
        return view(
            'catalog',
            [
                'events' => $filteredEvents
            ]
        );
    }

    // PENDING
    public function filter(Request $request) {
        // Getting filters
        $filters = $request->validate([ 'filters' => 'required|array|min:1' ]);

        // Making request
        $response = Http::get($this->url);

        // Filtering response
        dd($filters);
    }

    // PENDING
    public function paginate(Request $request) {
        //....
    }
}
