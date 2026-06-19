<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index() {
        // Check there's ticket in memory
        if(!session('ticket')) {
            return redirect('/');
        }

        dd(session('ticket'));
    }

    public function resend($id) {

    }
}
