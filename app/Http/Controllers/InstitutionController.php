<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\Country;
use App\Models\Institution;
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
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->input('country_id'));
        }

        $institutions = $query->orderBy('name')->paginate(10);

        return Inertia::render('institutions/index', ['institutions' => $institutions]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Institution::class);

        return Inertia::render('institutions/create', [
            'countries' => Country::select('id', 'name')->orderBy('name')->get(),
            'users' => Country::select('id', 'name')->where('role', UserType::TEACHER)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitutionRequest $request): RedirectResponse
    {
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
    public function show(Institution $institution)
    {
        Gate::authorize('view', $institution);

        return Inertia::render('institutions/show', [
            'institution' => $institution,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        Gate::authorize('update', $institution);

        return Inertia::render('institutions/edit', [
            'institution' => $institution,
            'countries' => Country::select('id', 'name')->orderBy('name')->get(),
            'users' => Country::select('id', 'name')->where('role', UserType::TEACHER)->orderBy('name')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionRequest $request, Institution $institution): RedirectResponse
    {
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
    public function destroy(Institution $institution)
    {
        Gate::authorize('delete', $institution);

        $institution->delete();

        return redirect()->route('institutions.index')
            ->with('success', 'Institutions Removed from Registry Successful');
    }

    public function restore(int $id): RedirectResponse
    {
        $termPaper = Institution::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $termPaper);

        $termPaper->restore();

        return redirect()->route('institutions.index')
            ->with('success', 'Institution Restored');
    }

}
