<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $users = User::orderByDesc('created_at')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $roles = Role::pluck('name');
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        $user->assignRole($validated['role']);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $roles = Role::pluck('name');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();
        $user->syncRoles([$validated['role']]);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
