<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        activity()->log('Dashboard page visited');
        $user = auth()->user();
        return view('dashboard', get_defined_vars());
    }
}
