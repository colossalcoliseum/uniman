<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Models\Institution;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Specialty::class);
        $query = Specialty::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('institution_id')) {
            $query->where('institution_id', $request->input('institution_id'));
        }
        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }

        $specialties = $query->with(['institution:id,name'])
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('specialties/index', ['specialties' => $specialties,    'filters' => ['trashed' => $request->boolean('trashed')],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Specialty::class);

        return Inertia::render('specialties/create', [
            'institutions' => Institution::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecialtyRequest $request): RedirectResponse
    {
        Gate::authorize('create', Specialty::class);

        Specialty::create($request->validated());

        return redirect()->route('specialties.index')
            ->with('success', 'Специалност Добавена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty): Response
    {
        Gate::authorize('view', $specialty);

        return Inertia::render('specialties/show', [
            'specialty' => $specialty->load(['institution:id,name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty): Response
    {
        Gate::authorize('update', $specialty);

        return Inertia::render('specialties/edit', [
            'specialty' => $specialty,
            'institutions' => Institution::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialtyRequest $request, Specialty $specialty): RedirectResponse
    {
        Gate::authorize('update', $specialty);

        $specialty->update($request->validated());

        return redirect()->route('specialties.index')
            ->with('success', 'Специалност Актуализирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty): RedirectResponse
    {
        Gate::authorize('delete', $specialty);

        $specialty->delete();

        return redirect()->route('specialties.index')
            ->with('success', 'Специалност Премахната');
    }

    public function restore(Specialty $specialty): RedirectResponse
    {
        Gate::authorize('restore', $specialty);

        $specialty->restore();

        return redirect()->route('specialties.index')
            ->with('success', 'Специалност Възстановена');
    }
}
