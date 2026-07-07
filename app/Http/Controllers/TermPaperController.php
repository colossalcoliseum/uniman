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
        $termPaperFile = $request->file('file_path');
        $termPaperFilePath = $termPaperFile->store('term-papers', 'public');
        $textContent = $this->extractContentsFromWordFile($termPaperFilePath);

        $termPaper = TermPaper::create([
            ...$data,
            'file_path' => $termPaperFilePath,
        ]);

        return redirect()->route('term-papers.index')
            ->with('success', 'Дипломна Работа Добавена');
    }

    /**
     * Display the specified resource.
     */
    public function show(TermPaper $termPaper): Response
    {
        Gate::authorize('view', $termPaper);

        $textContent = $this->extractContentsFromWordFile($termPaper->file_path);

        return Inertia::render('termPapers/show', [
            'termPaper' => $termPaper->load(['statusHistories', 'teacher', 'student', 'remark']),
            'termPaperTextContent' => $textContent,
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
        if ($request->hasFile('file_path')) {
            $termPaperFile = $request->file('file_path');
            $termPaperFilePath = $termPaperFile->store('term-papers', 'public');
            $termPaper->update([...$data,
                'file_path' => $termPaperFilePath]);
        }
        $termPaper->update($data);

        return redirect()->route('term-papers.index')
            ->with('success', 'Дипломна Работа Актуализирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('delete', $termPaper);
        $termPaper->delete();

        return redirect()->route('term-papers.index')
            ->with('success', 'Дипломна Работа Актуализирана');
    }

    public function restore(TermPaper $termPaper): RedirectResponse
    {
        Gate::authorize('restore', $termPaper);

        $termPaper->restore();

        return redirect()->route('term-papers.index')
            ->with('success', 'Дипломна Работа Възстановена');
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
            ->with('success', 'Тема Заявена Успешно');
    }

    private function extractContentsFromWordFile($termPaperFilePath): string
    {

        $striped_content = '';
        $content = '';
        $absolutePath = storage_path('app/public/'.$termPaperFilePath);

        $zip = zip_open($absolutePath);

        if (! $zip || is_numeric($zip)) {
            return 'Липсвва Файл';
        }

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == false) {
                continue;
            }

            if (zip_entry_name($zip_entry) != 'word/document.xml') {
                continue;
            }

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
}
