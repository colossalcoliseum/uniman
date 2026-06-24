<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    /**
     * Списък с учители - видим за всеки автентикиран потребител.
     */
    public function teachers(Request $request): Response
    {
        Gate::authorize('viewTeachers', User::class);

        $users = $this->filteredQuery($request, UserType::TEACHER)
            ->paginate(30)
            ->withQueryString();

        return Inertia::render('users/teachers', [
            'users' => $users,
            'filters' => ['search' => $request->input('search'), 'trashed' => $request->boolean('trashed')],
        ]);
    }

    /**
     * Списък със студенти - видим единствено за ректора (вж. UserPolicy::viewStudents).
     */
    public function students(Request $request): Response
    {
        Gate::authorize('viewStudents', User::class);

        $users = $this->filteredQuery($request, UserType::STUDENT)
            ->paginate(30)
            ->withQueryString();

        return Inertia::render('users/students', [
            'users' => $users,
            'filters' => ['search' => $request->input('search'), 'trashed' => $request->boolean('trashed')],
        ]);
    }

    /**
     * Обща заявка, споделена между teachers() и students() - филтрира
     * по тип потребител плюс по търсене/изтрити записи.
     */
    private function filteredQuery(Request $request, UserType $type)
    {
        $query = User::query()->where('type', $type->value);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }

        return $query->orderBy('name');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', User::class);

        return Inertia::render('users/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('create', User::class);

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.teachers')
            ->with('success', 'User Created Successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        return Inertia::render('users/show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return Inertia::render('users/edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        $data = $request->validated();
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.teachers')
            ->with('success', 'User Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.teachers')
            ->with('success', 'User Deleted');
    }

    public function toggleActive(User $user): RedirectResponse
    {
        Gate::authorize('toggleActive', $user);

        $user->update(['is_active' => ! $user->is_active]);

        $message = $user->is_active
            ? 'Account Was Activated.'
            : 'Account Was Deactivated.';

        return redirect()->back()->with('success', $message);
    }

    public function changeRole(ChangeUserRoleRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('changeRole', $user);
        $user->update($request->validated());

        return redirect()->back()->with('success', 'Role was updated.');
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $user);

        $user->restore();

        return redirect()->route('users.teachers')
            ->with('success', 'User Restored');
    }
}
