<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        activity()->log('Dashboard page visited');
        $users = User::where('id', '!=', Auth::id())
            ->whereHas('roles', function ($query) {
                $query->where('name', 'basic')
                    ->orWhere('name', 'moderator');
            })
            ->with('roles')
            ->paginate(50);

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
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', get_defined_vars());
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6', // Make password optional
        ]);

        // Only update the password if it's provided
        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        // Sync the roles (expects the role IDs from the form)
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
