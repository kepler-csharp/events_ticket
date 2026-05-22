<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function renderRegister() {
        view("register");
    }

    public function register(Request $request) {

    }

    public function renderLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $data = $request->validate(["email" => "required|email", "password" => "required"]);

        // Make request to API intermediary
        $url = env("API_URL")."auth/login";

        $response = Http::post($url, [
            "email" => $data["email"],
            "password" => $data["password"]
        ]);

        // Check that the user is authorized
        if(!$response->successful()) {
            return back()->withErrors([
                "message" => "Invalid Credentials"
            ]);
        }

        // Save token in laravel memory
        session("token", $response->json()["accessToken"]);
    }
}
