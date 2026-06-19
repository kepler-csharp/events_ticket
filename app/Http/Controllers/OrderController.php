<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    private $url;
    private $printUrl;

    public function __construct() {
        $this->url = config('api.url');
        $this->printUrl = config('api.print_url');
    }

    // Show Order Info
    public function index($id) {
        // Check there's order in memory
        if(!session('order')) {
            return redirect('/');
        }

        // Getting showtime
        $showtimeResponse = Http::withToken(session('token'))
            ->get($this->url."showtimes/".$id);

        // Checking response
        if(!$showtimeResponse->successful()) {
            return back()->withErrors([
                "failedReq" => $showtimeResponse->json('message')
            ]);
        }

        $showtime = $showtimeResponse['data'];

        // Calculating total price
        $totalPrice = (intval($showtime['basePrice']))*(count(json_decode(session("order")['seats'])));

        return view("order", compact("showtime", "totalPrice"));
    }

    // Confirm Order
    public function confirm(Request $request, $id) {
        // Getting request values
        $payMethod = $request->validate(['payMethod' => 'required'])['payMethod'];

        // Making request
        $confirmOrder = Http::withToken(session('token'))
            ->post($this->url.'receptionist/checkout', [
                "customerUserId" => session("order")['userId'],
               "seatIds" => json_decode(session("order")['seats']),
               "paymentMethod" => $payMethod
            ]);

        // Checking response
        if(!$confirmOrder->successful()) {
            return back()->withErrors([
                "failedReq" => $confirmOrder->json('message')
            ]);
        }

        // Emptying order memory
        session()->forget("order");

        // Saving ticket data in memory
        session()->put("tickets", $confirmOrder['data']);

        // Posting request
        //dd($confirmOrder);
        //Http::post($this->printUrl, $confirmOrder['data']);

        // Returning to same order
        return redirect('bill');
    }

    // Cancel order
    public function cancel() {
        // Emptying order memory
        session()->forget("order");

        // Returning to events catalog
        return redirect()->route("catalog.index");
    }
}
