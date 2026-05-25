<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    // Utils
    public function saveSession($token) {
        // Save token in memory
        session()->put('token', $token);

        // Destructuring token
        $userData = json_decode(base64_decode(
            // Separating token by doubts (.)
            explode('.', $token)[1]
        ), true); // True means that it will return the result as an array

        $user = [
            'id' => $userData['sub'],
            'fullname' => $userData['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'],
            'email' => $userData['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'],
            'role' => $userData['http://schemas.microsoft.com/ws/2008/06/identity/claims/role']
        ];

        // Save user in Auth
        session()->put('user', $user);
    }

    // Rendering pages
    public function renderRegister() {
        return view('register');
    }
    public function renderLogin() {
        return view('login');
    }

    // Logic Functions
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

        // Set session of user
        $this->saveSession($response->json()["accessToken"]);

        // Return to catalog
        return redirect('/');
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
                "failedReq" => "Invalid Credentials"
            ])->withInput();
        }

        // Set session of user
        $this->saveSession($response->json()["accessToken"]);

        // Redirect to catalog
        return redirect("/");
    }
}
