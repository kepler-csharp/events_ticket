<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    private $url;

    public function __construct() {
        $this->url = config('api.url');
    }

    public function index($id)
    {
        // Getting event and showtimes data
        $eventResponse = Http::get($this->url."events/".$id);
        $showtimeResponse = Http::get($this->url."showtimes?eventId=".$id);

        // Checking response
        if(!$eventResponse->successful() || !$showtimeResponse->successful()) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ])->withInput();
        }

        // Returning response
        $event = $eventResponse->json()['data'];
        $showtimes = $showtimeResponse->json()['data']['items'];

        return view('event.index', compact('event', 'showtimes'));
    }

    public function displaySeats($showtimeId) {
        // Making request for available seats
        $seatResponse = Http::get($this->url."showtimes/".$showtimeId."/seats");
        $showtimeResponse = Http::get($this->url."showtimes/".$showtimeId);

        // Checking response
        if(!$showtimeResponse->successful() || !$seatResponse->successful()) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ])->withInput();
        }

        // Returning response
        $showtime = $showtimeResponse['data'];
        $seats = $seatResponse->json()['data'];

        return view("event.seats", compact("showtime", "seats"));
    }

    public function buySeats($showtimeId, Request $request) {
        $seats = json_decode(($request->validate([ "seats" => "required" ])['seats']), true);
        $body = [
            "showtimeId" => $showtimeId,
            "seats" => $seats
        ];

        //dd($body);
        // Making request to reserve seats
        $seatResponse = Http::post($this->url."seats/reserve", $body);

        dd($seatResponse, session("token"), session("user"));
    }
}
