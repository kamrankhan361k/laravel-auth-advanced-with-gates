<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('is-admin');

        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.index', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        Gate::authorize('assign-role');

        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->assignRole($request->role);

        return back()->with('success', 'Role assigned successfully.');
    }
}
