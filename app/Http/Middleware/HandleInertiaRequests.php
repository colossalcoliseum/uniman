<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\Consultation;
use App\Models\Faculty;
use App\Models\Institution;
use App\Models\Recension;
use App\Models\Specialty;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'messages' => flash()->render('array'),
            'sidebarOpen' => !$request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'can' => $request->user() ? [
                'termPapers' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', TermPaper::class),
                ],
                'consultations' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', Consultation::class),
                ],
                'recensions' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', Recension::class),
                ],
                'specialties' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', Specialty::class),
                ],
                'faculties' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', Faculty::class),
                ],
                'institutions' => [
                    'viewAny' => Gate::forUser($user)->allows('viewAny', Institution::class),
                ],
                'users' => [
                    'viewTeachers' => Gate::forUser($user)->allows('viewTeachers', User::class),
                    'viewStudents' => Gate::forUser($user)->allows('viewStudents', User::class),
                    'viewIndividualProfiles' => $user->role === UserRole::RECTOR,
                ],
            ] : [],

        ];
    }
}
