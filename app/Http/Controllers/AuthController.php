<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function renderRegister() {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "fullName" => "required|min:4|max:30",
            "email" => "required|email",
            "password" => [
                "required",
                "max:100",
                //Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        // Make request to API intermediary
        $url = env("API_URL") . "auth/register-receptionist";

        $response = Http::post($url, $data);

        // Check errors
        if($response->status() == 401) {
            return back()->withErrors([
                "failedReq" => "Unauthorized to do this action"
            ])->withInput();
        }

        // Save token in memory
        session("token", $response->json()["accessToken"]);

        // Return to catalog
        return redirect('/');
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

        // Redirect to catalog
        return redirect("/");
    }
}
