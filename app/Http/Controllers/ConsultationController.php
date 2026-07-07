<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserType;
use App\Http\Requests\StoreConsultationRequest;
use App\Http\Requests\UpdateConsultationRequest;
use App\Models\Consultation;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Consultation::class);
        $user = $request->user();
        $query = Consultation::query();

        if ($user->role !== UserRole::ADMIN) {
            $query->where(function ($query) use ($user) {
                $query->where('teacher_id', $user->id)
                    ->orWhere('student_id', $user->id);
            });
        }

        if ($request->filled('type')) {
            $query->ofType($request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }
        $consultations = $query->with(['teacher:id,name', 'student:id,name', 'termPaper:id,name'])
            ->orderBy('starts_at')
            ->paginate(10);

        return Inertia::render('consultations/index', [
            'consultations' => $consultations,
            'filters' => ['trashed' => $request->boolean('trashed')],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        Gate::authorize('create', Consultation::class);

        $termPapersQuery = TermPaper::whereNotNull('student_id');
        if (auth()->user()->role !== UserRole::ADMIN) {
            $termPapersQuery->where('teacher_id', auth()->id());
        }

        return Inertia::render('consultations/create', [
            'students' => User::where('type', UserType::STUDENT->value)->select('id', 'name')->get(),
            'termPapers' => $termPapersQuery->select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        Gate::authorize('create', Consultation::class);
        $data = $request->validated();

        $termPaper = TermPaper::findOrFail($data['term_paper_id']);

         abort_if(
            $termPaper->teacher_id !== auth()->id() && auth()->user()->role !== UserRole::ADMIN,
            403
        );

        $data['teacher_id'] = $termPaper->teacher_id;

        Consultation::create($data);

        return redirect()->route('consultations.index')
            ->with('success', 'Консутация Добавена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation): Response
    {
        Gate::authorize('view', $consultation);

        return Inertia::render('consultations/show', [
            'consultation' => $consultation->load(['teacher:id,name', 'student:id,name', 'termPaper:id,name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultation $consultation): Response
    {
        Gate::authorize('update', $consultation);
        $termPapersQuery = TermPaper::whereNotNull('student_id');
        if (auth()->user()->role !== UserRole::ADMIN) {
            $termPapersQuery->where('teacher_id', auth()->id());
        }

        return Inertia::render('consultations/edit', [
            'consultation' => $consultation,
            'teachers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
            'students' => User::where('type', UserType::STUDENT->value)->select('id', 'name')->get(),
            'termPapers' => $termPapersQuery->select('id', 'name')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultationRequest $request, Consultation $consultation): RedirectResponse
    {
        Gate::authorize('update', $consultation);
        $data = $request->validated();

        $termPaper = TermPaper::findOrFail($data['term_paper_id']);
        abort_if(
            $termPaper->teacher_id !== auth()->id() && auth()->user()->role !== UserRole::ADMIN,
            403
        );
        $data['teacher_id'] = $termPaper->teacher_id;

        $consultation->update($data);

        return redirect()->route('consultations.index')
            ->with('success', 'Консултация Актуализирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation): RedirectResponse
    {
        Gate::authorize('delete', $consultation);
        $consultation->delete();

        return redirect()->route('consultations.index')
            ->with('success', 'Консултация Премахната');
    }
    public function calendar(): Response
    {
        Gate::authorize('viewAny', Consultation::class);

        return Inertia::render('consultations/calendar', [
            'teachers' => User::where('type', UserType::TEACHER->value)->select('id', 'name')->get(),
        ]);
    }

    public function calendarData(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $query = Consultation::query();

        if ($user->role !== UserRole::ADMIN) {
            $query->where(function ($query) use ($user) {
                $query->where('teacher_id', $user->id)
                    ->orWhere('student_id', $user->id);
            });
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        $events = $query->with(['teacher:id,name', 'student:id,name'])
            ->get()
            ->map(fn (Consultation $consultation) => [
                'id' => $consultation->id,
                'title' => $consultation->student?->name ?? 'Консултация',
                'start' => $consultation->starts_at,
                'end' => $consultation->ends_at,
            ]);

        return response()->json($events);
    }
}
