<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    private $url;

    public function __construct() {
        $this->url = config('api.url');
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
                "failedReq" => "Server may be down"
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
                "failedReq" => "Server may be down"
            ]);
        }

        // Emptying order memory
        session()->forget("order");

        // Saving ticket data in memory
        session()->put("tickets", $confirmOrder['data']);

        // Returning to same order
        return route('bill.index');
    }

    // Cancel order
    public function cancel() {
        // Emptying order memory
        session()->forget("order");

        // Returning to events catalog
        return redirect()->route("catalog.index");
    }

    // Resend Email
    public function resend($id) {
        // Checking that order is completed
        $order = (Http::withToken(session('token'))->get($this->url.'orders/'.$id));

        if(!$order->successful()) {
            return back()->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        if($order['status'] != 1) {
            return back()->withErrors([
                "failedReq" => "Order must be completed for resend emails"
            ]);
        }

        // Make request for resend emails
        $resendOrder = Http::withToken(session('token'))
            ->post($this->url.'orders/pay', ["id" => $id]);

        // Checking response
        if(!$resendOrder->successful()) {

            return back()->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        return back()->with('success', 'Emails sent successfully');
    }
}
