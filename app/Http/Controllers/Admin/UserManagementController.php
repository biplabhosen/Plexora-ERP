<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $roleId = $request->integer('role_id');

        $users = User::query()
            ->with('role:id,name')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($roleId, fn ($query) => $query->where('role_id', $roleId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
            'search' => $search,
            'selectedRoleId' => $roleId ?: null,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($request->validated() + [
            'status' => User::STATUS_ACTIVE,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user->load('role:id,name'),
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] ??= $user->status;

        if ($user->is($request->user()) && $validated['status'] === User::STATUS_INACTIVE) {
            return back()
                ->withInput()
                ->with('error', 'You cannot deactivate your own account.');
        }

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        $nextStatus = $user->status === User::STATUS_ACTIVE
            ? User::STATUS_INACTIVE
            : User::STATUS_ACTIVE;

        if ($user->is($request->user()) && $nextStatus === User::STATUS_INACTIVE) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['status' => $nextStatus]);

        return back()->with('success', 'User status updated successfully.');
    }
}
