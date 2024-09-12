<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        activity()->log('Dashboard page visited');
        return view('dashboard');
    }
}
