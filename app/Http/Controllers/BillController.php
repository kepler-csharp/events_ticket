<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BillController extends Controller
{
    private $url;

    public function __construct() {
        $this->url = config('api.url');
    }

    public function index() {
        // Check there's ticket in memory
        if(!session('tickets')) {
            return redirect('/');
        }

        $order = session('tickets');

        // Returning view
        return view('bill', compact('order'));
    }

    public function resend() {
        // Checking that order is completed
        if(!session('tickets')) {
            return redirect()->route('/')->withErrors([
                "failedReq" => "You must have confirmed an order"
            ]);
        }

        // Make request for resend emails
        $orderId = session('tickets')["orderId"];

        $resendOrder = Http::withToken(session('token'))
            ->post($this->url.'receptionist/orders/'.$orderId.'/resend-email');

        // Checking response
        if(!$resendOrder->successful()) {
            return back()->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        return back()->with('success', 'Emails sent successfully');
    }
}
