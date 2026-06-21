<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Country;
use App\Models\Faculty;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Faculty::class);
        $query = Faculty::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('institution_id')) {
            $query->where('institution_id', $request->input('institution_id'));
        }

        $institutions = $query->orderBy('name')->paginate(10);

        return Inertia::render('institutions/index', ['institutions' => $institutions]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Faculty::class);

        return Inertia::render('faculties/create',
            [
                'institutions' => Institution::select('id', 'name')->orderBy('name')->get(),
                'countries' => Country::select('id', 'name')->orderBy('name')->get(),
                'deans' => User::ofRole(UserRole::DEAN)->select('id', 'name')->orderBy('name')->get(),

            ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacultyRequest $request): RedirectResponse
    {
        Faculty::create($request->validated());

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty Registered Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        Gate::authorize('view', $faculty);

        return Inertia::render('faculties/show', [
            'faculty' => $faculty,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        Gate::authorize('update', $faculty);

        return Inertia::render('faculties/edit', [
            'faculty' => $faculty,
            'institutions' => Institution::select('id', 'name')->orderBy('name')->get(),
            'countries' => Country::select('id', 'name')->orderBy('name')->get(),
            'deans' => User::ofRole(UserRole::DEAN)->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $data = $request->validated();
        $faculty->update($data);

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty Registered Successful');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        Gate::authorize('delete', $faculty);
        $faculty->delete();

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty Removed  Successful');

    }
    public function restore(int $id): RedirectResponse
    {
        $termPaper = Faculty::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $termPaper);

        $termPaper->restore();

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty Restored');
    }
}
