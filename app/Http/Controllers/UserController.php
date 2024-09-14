<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'User List',
                'action' => 'visited',
                'ip' => request()->ip(),
            ])
            ->log('User visited their profile page'); // Custom log message

        $users = User::where('id', '!=', Auth::id())
            ->whereHas('roles', function ($query) {
                $query->where('name', 'basic')
                    ->orWhere('name', 'moderator');
            })
            ->with('roles')
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'User Profile',
                'action' => 'visited',
                'ip' => request()->ip(),
            ])
            ->log('User visited their profile page'); // Custom log message

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        activity()
            ->performedOn(Auth::check() ? User::find(Auth::id()) : null)
            ->withProperties([
                'page' => 'User Profile',
                'action' => 'visited',
                'ip' => request()->ip(),
            ])
            ->log('User visited their profile page'); // Custom log message

        $roles = Role::all();
        return view('users.edit', get_defined_vars());
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6', // Make password optional
            'roles' => 'required|array',
            'self_define_word' => 'nullable',
        ]);

        // Only update the password if it's provided
        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->filled('self_define_word')) {
            $data['self_define_word'] = $request->self_define_word;
        }

        $user->update($data);
        try {
            $this->getSynonyms($request->self_define_word, $user);
        } catch (\Throwable $th) {
            Log::error('Error fetching synonyms: ' . $th->getMessage());
        }
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
