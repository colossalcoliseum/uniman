<?php

namespace App\Http\Controllers;

use App\Models\TermPaper;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $termPapers = TermPaper::query()
            ->with(['teacher:id,name', 'student:id,name'])
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('dashboard', [
            'termPapers' => $termPapers,
            'filters' => $request->only('search'),
        ]);
    }
}
