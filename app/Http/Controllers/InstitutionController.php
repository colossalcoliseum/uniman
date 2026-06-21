<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\Country;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Institution::class);
        $query = Institution::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->input('country_id'));
        }
        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }
        $institutions = $query->with(['country:id,name', 'manager:id,name'])
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('institutions/index', ['institutions' => $institutions,    'filters' => ['trashed' => $request->boolean('trashed')],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Institution::class);

        return Inertia::render('institutions/create', [
            'countries' => Country::select('id', 'name')->orderBy('name')->get(),
            'users' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitutionRequest $request): RedirectResponse
    {
        Gate::authorize('create', Institution::class);

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('institutions', 'public');
        }

        Institution::create($data);

        return redirect()->route('institutions.index')
            ->with('success', 'Institutions Registered Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution): Response
    {
        Gate::authorize('view', $institution);

        return Inertia::render('institutions/show', [
            'institution' => $institution->load(['country:id,name', 'manager:id,name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution): Response
    {
        Gate::authorize('update', $institution);

        return Inertia::render('institutions/edit', [
            'institution' => $institution,
            'countries' => Country::select('id', 'name')->orderBy('name')->get(),
            'users' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionRequest $request, Institution $institution): RedirectResponse
    {
        Gate::authorize('update', $institution);

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('institutions', 'public');
        }

        $institution->update($data);

        return redirect()->route('institutions.index')
            ->with('success', 'Institutions Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution): RedirectResponse
    {
        Gate::authorize('delete', $institution);

        $institution->delete();

        return redirect()->route('institutions.index')
            ->with('success', 'Institutions Removed from Registry Successful');
    }

    public function restore(Institution $institution): RedirectResponse
    {
        Gate::authorize('restore', $institution);

        $institution->restore();

        return redirect()->route('institutions.index')
            ->with('success', 'Institution Restored');
    }
}
