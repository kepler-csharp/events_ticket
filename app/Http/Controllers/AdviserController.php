<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdviserController extends Controller
{
    private $url;

    public function __construct() {
        $this->url = config('api.url');
    }

    public function index() {
        // Getting advisers
        $advisersResponse = Http::get($this->url.'admin/employees');
        $advisers = [];

        // Checking response
        if(!$advisersResponse->successful()) {
            return view('adviser.index', compact('advisers'))->withErrors([
                "failedReq" => "Server may be down"
            ]);
        }

        if($advisersResponse->status() == 403) {
            return view('adviser.index', compact('advisers'))->withErrors([
                "failedReq" => "You should be logged as admin"
            ]);
        }

        $advisers = $advisersResponse->json()['data']['items'];

        return view('adviser.index');
    }

    public function create() {
        return view('adviser.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            "fullName" => "required|min:4|max:30",
            "email" => "required|email",
            "password" => [
                "required",
                "max:100",
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        // Make request to API intermediary
        $response = Http::post($this->url."auth/register-receptionist", $data);

        // Check errors
        if($response->status() == 401) {
            return back()->withErrors([
                "failedReq" => "Unauthorized to do this action"
            ])->withInput();
        }

        return redirect()->route('adviser.index')->with('success', 'Adviser created successfully');
    }
}
