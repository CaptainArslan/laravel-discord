<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'Dashboard page',
                'action' => 'visited',
                'ip' => request()->ip(),
            ])
            ->log('User visited the dashboard page');
        $user = Auth::user();
        return view('dashboard', get_defined_vars());
    }

    public function activity()
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'Activity list page',
                'action' => 'visited',
                'ip' => request()->ip(),
            ])
            ->log('User visited their profile page');
        $activities = Activity::latest()->paginate(10);
        // dd($activities->toArray());
        return view('users.activity', get_defined_vars());
    }

    public function destroyActivity($id)
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'Delete activity',
                'action' => 'deleted',
                'ip' => request()->ip(),
            ])
            ->log('User deleted an activity');
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return to_route('user.activity')->with('success', 'Activity deleted successfully');
    }
}
