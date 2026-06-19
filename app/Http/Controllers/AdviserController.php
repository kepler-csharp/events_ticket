<?php

namespace App\Http\Controllers;

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

        return redirect()->route('adviser.index')->with('');
    }
}
