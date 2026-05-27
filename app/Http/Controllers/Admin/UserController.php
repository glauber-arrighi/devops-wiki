<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'groups'])->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles  = Role::orderBy('label')->get();
        $groups = Group::where('active', true)->orderBy('label')->get();
        return view('admin.users.create', compact('roles', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'role_id'  => 'required|exists:roles,id',
            'groups'   => 'nullable|array',
            'groups.*' => 'exists:groups,id',
            'active'   => 'boolean',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => $validated['role_id'],
            'active'   => $request->boolean('active', true),
        ]);

        $user->groups()->sync($request->groups ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário {$user->name} criado com sucesso!");
    }

    public function edit(User $user)
    {
        $roles  = Role::orderBy('label')->get();
        $groups = Group::where('active', true)->orderBy('label')->get();
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:users,email,{$user->id}",
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()],
            'role_id'  => 'required|exists:roles,id',
            'groups'   => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role_id' => $validated['role_id'],
            'active'  => $request->boolean('active'),
            ...($validated['password'] ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        $user->groups()->sync($request->groups ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário {$user->name} atualizado!");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Você não pode remover sua própria conta.']);
        }
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário removido.');
    }
}
