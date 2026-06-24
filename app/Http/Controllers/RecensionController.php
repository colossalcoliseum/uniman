<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserType;
use App\Http\Requests\StoreRecensionRequest;
use App\Http\Requests\UpdateRecensionRequest;
use App\Models\Recension;
use App\Models\Remark;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RecensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Recension::class);
        $query = Recension::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            });
        }
        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }
        if ($request->filled('reviewer_id')) {
            $query->where('reviewer_id', $request->input('reviewer_id'));
        }

        $user = $request->user();
        $isAdmin = $user->role === UserRole::ADMIN;
        $isOverseer = in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);

        if (! $isAdmin && ! $isOverseer) {
            $query->where('reviewer_id', $user->id);
        }

        $recensions = $query->with(['reviewer:id,name', 'remark:id,name', 'termPaper:id,name'])
            ->orderBy('title')
            ->paginate(10);

        return Inertia::render('recensions/index', [
            'recensions' => $recensions,
            'filters' => ['trashed' => $request->boolean('trashed')],
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', Recension::class);

        return Inertia::render('recensions/create', [
            'reviewers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
            'remarks' => Remark::all(['id', 'name']),
            'termPapers' => TermPaper::select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecensionRequest $request): RedirectResponse
    {
        Gate::authorize('create', Recension::class);
        $data = $request->validated();

        Recension::create($data);

        return redirect()->route('recensions.index')
            ->with('success', 'Recension Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recension $recension): Response
    {
        Gate::authorize('view', $recension);

        return Inertia::render('recensions/show', [
            'recension' => $recension->load(['reviewer:id,name', 'remark:id,name', 'termPaper:id,name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recension $recension): Response
    {
        Gate::authorize('update', $recension);

        return Inertia::render('recensions/edit', [
            'recension' => $recension,
            'reviewers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
            'remarks' => Remark::all(['id', 'name']),
            'termPapers' => TermPaper::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecensionRequest $request, Recension $recension): RedirectResponse
    {
        Gate::authorize('update', $recension);
        $data = $request->validated();
        $recension->update($data);

        return redirect()->route('recensions.index')
            ->with('success', 'Recension Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recension $recension): RedirectResponse
    {
        Gate::authorize('delete', $recension);
        $recension->delete();

        return redirect()->route('recensions.index')
            ->with('success', 'Recension Removed');
    }

    public function restore(Recension $recension): RedirectResponse
    {
        Gate::authorize('restore', $recension);

        $recension->restore();

        return redirect()->route('recensions.index')
            ->with('success', 'Recension Restored');
    }
}
