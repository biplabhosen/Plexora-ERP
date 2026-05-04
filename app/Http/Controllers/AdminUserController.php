<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $role = $request->string('role')->toString();

        $users = User::query()
            ->with(['role', 'supplier'])
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query) use ($role): void {
                $query->whereHas('role', function ($builder) use ($role): void {
                    $builder->where('name', $role);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
            'search' => $search,
            'selectedRole' => $role,
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user->load(['role', 'supplier']),
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $newRole = Role::query()->findOrFail($validated['role_id']);

        if ($user->id === $request->user()->id && $newRole->name !== 'admin') {
            return redirect()
                ->back()
                ->withInput()
                ->with('info', 'You cannot remove your own admin access.');
        }

        if ($newRole->name === 'supplier' && $user->supplier?->status !== 'approved') {
            return redirect()
                ->back()
                ->withInput()
                ->with('info', 'Only approved supplier applications can receive the supplier role.');
        }

        if ($user->supplier?->status === 'approved' && $newRole->name !== 'supplier') {
            return redirect()
                ->back()
                ->withInput()
                ->with('info', 'Approved suppliers must be managed from the supplier approval panel.');
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('info', 'You cannot delete your own account from the admin panel.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
