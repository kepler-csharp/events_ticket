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

        // Check the user exists
        $userResponse = Http::post($this->url."receptionist/customers/lookup".$id, $data['email']);

        // Creating user if wasn't succesfull
        if($userResponse->getStatusCode() == 404 && (!isset($data['fullname']) && !isset($data['phone']))) {
            return back()->withErrors([
                "email" => "That user doesn't exists. Please, create it below"
            ])->withInput();
        } else if ($userResponse->getStatusCode() == 404) {
            $dataUser = request()->validate(["fullname" => "required|regex:/^[\pL\s]+$/u|min:3|max:30", "phone" => "required|numeric"]);

            // Creating user
            $newUserResponse = Http::withToken(session('token'))
                ->withOptions(['debug' => true])
                ->post($this->url."receptionist/customers", [
                "fullName" => $data["fullname"],
                "phone" => $data["phone"],
                "email" => $data["email"],
            ]);
        }

        // Reserve seats
        /*$orderResponse = Http::post($this->url."receptionist/checkout", [
            $customerUserId;
        ]);*/

        // Redirect to order view

    }
}
