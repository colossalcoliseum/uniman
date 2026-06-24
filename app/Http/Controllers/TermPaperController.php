<?php

namespace App\Http\Controllers;

use App\Enums\TermPaperStatus;
use App\Enums\UserType;
use App\Http\Requests\StoreTermPaperRequest;
use App\Http\Requests\UpdateTermPaperRequest;
use App\Models\Remark;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TermPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', TermPaper::class);
        $query = TermPaper::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->input('student_id'));
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }
        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }
        $termPapers = $query->with('teacher:id,name', 'student:id,name', 'remark:id,name')->orderBy('name')->paginate(10);

        return Inertia::render('termPapers/index', ['termPapers' => $termPapers, 'filters' => ['trashed' => $request->boolean('trashed')]]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('create', TermPaper::class);

        return Inertia::render('termPapers/create', [
            'teachers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
            'students' => User::where('type', UserType::STUDENT->value)->select('id', 'name')->get(),
            'remarks' => Remark::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTermPaperRequest $request): RedirectResponse
    {
        Gate::authorize('create', TermPaper::class);
        $data = $request->validated();

        TermPaper::create($data);

        return redirect()->route('term-papers.index')
            ->with('success', 'Term Paper Added');
    }

    /**
     * Display the specified resource.
     */
        public function show(TermPaper $termPaper): Response
        {
            Gate::authorize('view', $termPaper);

            return Inertia::render('termPapers/show', [
                'termPaper' =>     $termPaper->load(['statusHistories', 'teacher', 'student', 'remark']),
            ]);
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TermPaper $termPaper): Response
    {
        Gate::authorize('update', $termPaper);

        return Inertia::render('termPapers/edit', [
            'termPaper' => $termPaper,
            'teachers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
            'students' => User::where('type', UserType::STUDENT->value)->select('id', 'name')->get(),
            'remarks' => Remark::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTermPaperRequest $request, TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('update', $termPaper);
        $data = $request->validated();
        $termPaper->update($data);

        return redirect()->route('term-papers.index')
            ->with('success', 'Term Paper Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('delete', $termPaper);
        $termPaper->delete();

        return redirect()->route('term-papers.index')
            ->with('success', 'Term Paper Removed');
    }

    public function restore(TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('restore', $termPaper);

        $termPaper->restore();

        return redirect()->route('term-papers.index')
            ->with('success', 'Term Paper Restored');
    }
    public function claim(TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('claim', $termPaper);

        $termPaper->update([
            'student_id' => auth()->id(),
            'status' => TermPaperStatus::PENDING,
            'claimed_at' => now(),
        ]);

        return redirect()->route('term-papers.index')
            ->with('success', 'Заявихте темата успешно');
    }
}
