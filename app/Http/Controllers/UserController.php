<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->can('users.view'), 403);

        return view('users.index', [
            'users' => User::with('roles', 'permissions')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->can('users.create'), 403);

        return view('users.create', $this->formData(new User()));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));
        $user->permittedFolders()->sync($request->input('folder_permissions', []));

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        abort_unless(auth()->user()?->can('users.edit'), 403);

        return view('users.edit', $this->formData($user));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = [
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->string('password')->toString());
        }

        $user->update($data);
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));
        $user->permittedFolders()->sync($request->input('folder_permissions', []));

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless(auth()->user()?->can('users.delete'), 403);
        abort_if(auth()->id() === $user->id, 422, 'No puedes eliminar tu propio usuario.');

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function formData(User $user): array
    {
        return [
            'user' => $user->loadMissing('roles', 'permissions', 'permittedFolders'),
            'roles' => Role::orderBy('name')->get(),
            'folders' => Folder::ordered()->get(),
            'permissionsByGroup' => Permission::orderBy('name')
                ->get()
                ->groupBy(fn (Permission $permission) => str($permission->name)->before('.')->toString()),
        ];
    }
}
