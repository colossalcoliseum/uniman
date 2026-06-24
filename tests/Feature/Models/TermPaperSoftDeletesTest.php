<?php

namespace Tests\Feature\Models;

use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermPaperSoftDeletesTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_term_paper_sets_deleted_at_instead_of_removing_row(): void
    {
        $teacher = User::factory()->professor()->create();
        $student = User::factory()->student()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'remark_id' => null,
        ]);

        $termPaper->delete();

        $this->assertSoftDeleted($termPaper);
        $this->assertDatabaseHas('term_papers', [
            'id' => $termPaper->id,
            'deleted_at' => $termPaper->fresh()?->deleted_at,
        ]);
    }

    public function test_soft_deleted_term_paper_is_excluded_from_default_queries(): void
    {
        $teacher = User::factory()->professor()->create();
        $student = User::factory()->student()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'remark_id' => null,
        ]);
        $termPaperId = $termPaper->id;

        $termPaper->delete();

        $this->assertNull(TermPaper::find($termPaperId));
        $this->assertNotNull(TermPaper::withTrashed()->find($termPaperId));
    }

    public function test_restoring_term_paper_makes_it_visible_again(): void
    {
        $teacher = User::factory()->professor()->create();
        $student = User::factory()->student()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'remark_id' => null,
        ]);
        $termPaperId = $termPaper->id;

        $termPaper->delete();
        $this->assertNull(TermPaper::find($termPaperId));

        $termPaper->restore();

        $restored = TermPaper::find($termPaperId);
        $this->assertNotNull($restored);
        $this->assertNull($restored->deleted_at);
    }

    public function test_only_trashed_scope_returns_only_soft_deleted_records(): void
    {
        $teacher = User::factory()->professor()->create();
        $studentOne = User::factory()->student()->create();
        $studentTwo = User::factory()->student()->create();

        $activeTermPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $studentOne->id,
            'remark_id' => null,
        ]);
        $deletedTermPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $studentTwo->id,
            'remark_id' => null,
        ]);
        $deletedTermPaper->delete();

        $trashedIds = TermPaper::onlyTrashed()->pluck('id');

        $this->assertTrue($trashedIds->contains($deletedTermPaper->id));
        $this->assertFalse($trashedIds->contains($activeTermPaper->id));
    }
}
