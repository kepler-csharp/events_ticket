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
        $order = (Http::withToken(session('token'))
            ->get($this->url.'orders/'.$id))->json()['data'];

        return view("order", compact("order"));
    }

    // Confirm Order
    public function confirm($id) {
        // Making request
        $confirmOrder = Http::withToken(session('token'))
            ->post($this->url.'orders/pay', [
               "orderId" => $id,
               "paymentMethod" => "completed"
            ]);

        // Checking response
        if(!$confirmOrder->successful()) {
            return back()->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        // Returning to ticket view
    }

    // Cancel order
    public function cancel($id) {
        // Making request
        $cancelOrder = Http::withToken(session("token"))
            ->post($this->url.'orders/pay', [
                "orderId" => $id,
                "paymentMethod" => "cancelled"
            ]);

        if(!$cancelOrder->successful()) {
            return back()->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        // Returning to events catalog
        return redirect()->route("catalog.index");
    }
}
