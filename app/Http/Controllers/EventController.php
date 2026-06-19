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

    public function buySeats(Request $request, $id) {
        $data = request()->validate(["seats" => "required", "email" => "required|email", "fullname" => "sometimes", "phone" => "sometimes"]);
        $seats = json_decode($data['seats']);

        // Check the user exists
        $userResponse = Http::withToken(session("token"))->get($this->url."receptionist/customers/lookup?email=".$data['email']);

        // Creating user if user doesn't exist
        if($userResponse->getStatusCode() == 404 && (!isset($data['fullname']) && !isset($data['phone']))) {
            // If queries weren't sent, request them
            return back()->withErrors([
                "email" => "That user doesn't exists. Please, create it below"
            ])->withInput();
        } else if ($userResponse->getStatusCode() == 404) {
            $dataUser = request()->validate(["fullname" => "required|regex:/^[\pL\s]+$/u|min:3|max:30", "phone" => "required|numeric"]);

            // Creating user
            $userResponse = Http::withToken(session('token'))
                ->withOptions(['debug' => true])
                ->post($this->url."receptionist/customers", [
                    "fullName" => $dataUser["fullname"],
                    "phone" => $dataUser["phone"],
                    "email" => $data["email"],
            ]);

            // Checking response
            if(!$userResponse->successful()) {
                return back()->withErrors([
                    "failedReq" => "The request failed. Server may be down."
                ]);
            }
        }

        // Saving User ID and seats in memory
        session()->put("order", [
            "userId" => $userResponse->json()['data']["userId"],
            "seats" => $data['seats']
        ]);

        // Reserve seats
        $seatResponse = Http::withToken(session('token'))
            ->post($this->url."receptionist/reserve", [
                "customerUserId" => session("order")['userId'],
                "showtimeId" => $id,
                "seatIds" => $seats
        ]);

        /*dd($seatResponse, [
            "customerUserId" => session("order")['userId'],
            "showtimeId" => $id,
            "seatIds" => $seats
        ]);*/

        // Checking seat reserve response
        if(!$seatResponse->successful()) {
            return back()->withErrors([
                "failedReq" => "The request failed. Server may be down."
            ]);
        }

        // Redirect to order confirmation view
        return redirect()->route('order.index', $id);
    }
}
