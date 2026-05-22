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

        $response = Http::post(env("API_URL")."/auth/login", [
            "email" => $data["email"],
            "password" => $data["password"]
        ]);

        dd($response);
    }
}
