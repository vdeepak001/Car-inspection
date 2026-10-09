<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the user list.
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'title' => 'Users',
            'users' => User::query()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a website account.
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'title' => 'Add user',
        ]);
    }

    /**
     * Store a website account.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($request->safe()->only([
            'name',
            'phone',
            'email',
            'password',
        ]));

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'User created.');
    }

    /**
     * Show one account.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'title' => $user->name,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing an account.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'title' => 'Edit user',
            'user' => $user,
        ]);
    }

    /**
     * Update an account. A blank password leaves the current one in place.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->safe()->only(['name', 'phone', 'email']);

        if ($request->filled('password')) {
            $attributes['password'] = $request->string('password')->toString();
        }

        $user->update($attributes);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('status', 'User updated.');
    }

    /**
     * Delete an account other than the one that is signed in.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user('admin')?->is($user)) {
            return back()->withErrors([
                'user' => 'You cannot delete the account you are signed in with.',
            ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'User deleted.');
    }
}
