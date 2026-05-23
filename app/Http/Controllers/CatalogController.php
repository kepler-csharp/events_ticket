<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatalogController extends Controller
{
    public function index()
    {
        // Getting events data
        $url = env('API_URL').'events';

        $response = Http::get($url);
        $events = $response->json()['data'];

        // Passing data to view
        return view('catalog', compact('events'));
    }
}
