<?php

namespace Tests\Feature\Policies;

use App\Enums\TermPaperStatus;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TermPaperPolicyTest extends TestCase
{
    use RefreshDatabase;

    private function unassignedStudentId(): int
    {
        return User::factory()->student()->create()->id;
    }

    public function test_admin_passes_every_ability_via_before_hook(): void
    {
        $admin = User::factory()->admin()->create();
        $teacher = User::factory()->professor()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
            'status' => TermPaperStatus::AVAILABLE,
        ]);

        $this->assertTrue($admin->can('view', $termPaper));
        $this->assertTrue($admin->can('update', $termPaper));
        $this->assertTrue($admin->can('delete', $termPaper));
        $this->assertTrue($admin->can('restore', $termPaper));
        $this->assertTrue($admin->can('create', TermPaper::class));
    }

    public function test_only_professor_and_associate_professor_can_create_term_papers(): void
    {
        $professor = User::factory()->professor()->create();
        $associateProfessor = User::factory()->associateProfessor()->create();
        $assistant = User::factory()->assistant()->create();

        $this->assertTrue($professor->can('create', TermPaper::class));
        $this->assertTrue($associateProfessor->can('create', TermPaper::class));
        $this->assertFalse($assistant->can('create', TermPaper::class));
    }

    public function test_only_owning_teacher_can_update_term_paper(): void
    {
        $owningTeacher = User::factory()->professor()->create();
        $otherTeacher = User::factory()->professor()->create();

        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $owningTeacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
        ]);

        $this->assertTrue($owningTeacher->can('update', $termPaper));
        $this->assertFalse($otherTeacher->can('update', $termPaper));
    }

    public function test_delete_allowed_for_owning_teacher_or_rector_or_dean(): void
    {
        $owningTeacher = User::factory()->professor()->create();
        $otherTeacher = User::factory()->professor()->create();
        $rector = User::factory()->rector()->create();
        $dean = User::factory()->dean()->create();

        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $owningTeacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
        ]);

        $this->assertTrue($owningTeacher->can('delete', $termPaper));
        $this->assertTrue($rector->can('delete', $termPaper));
        $this->assertTrue($dean->can('delete', $termPaper));
        $this->assertFalse($otherTeacher->can('delete', $termPaper));
    }

    public function test_force_delete_is_never_allowed_for_non_admin(): void
    {
        $rector = User::factory()->rector()->create();
        $teacher = User::factory()->professor()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
        ]);

        $this->assertFalse($rector->can('forceDelete', $termPaper));
    }

    public function test_student_can_claim_available_unclaimed_term_paper(): void
    {
        $student = User::factory()->student()->create();
        $teacher = User::factory()->professor()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
            'status' => TermPaperStatus::AVAILABLE,
        ]);

        // Симулираме "непотърсена" тема в паметта, без да я записваме в БД,
        // за да тестваме Policy логиката такава, каквато е писана в кода.
        $termPaper->student_id = null;

        $this->assertTrue($student->can('claim', $termPaper));
    }

    public function test_student_cannot_claim_already_claimed_term_paper(): void
    {
        $firstStudent = User::factory()->student()->create();
        $secondStudent = User::factory()->student()->create();
        $teacher = User::factory()->professor()->create();

        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $firstStudent->id,
            'remark_id' => null,
            'status' => TermPaperStatus::PENDING,
        ]);

        $this->assertFalse($secondStudent->can('claim', $termPaper));
    }

    public function test_student_cannot_claim_term_paper_with_non_available_status(): void
    {
        $student = User::factory()->student()->create();
        $teacher = User::factory()->professor()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
            'status' => TermPaperStatus::IN_REVIEW,
        ]);

        $termPaper->student_id = null;

        $this->assertFalse($student->can('claim', $termPaper));
    }

    public function test_teacher_cannot_claim_term_paper(): void
    {
        $teacher = User::factory()->professor()->create();
        $termPaper = TermPaper::factory()->create([
            'teacher_id' => $teacher->id,
            'student_id' => $this->unassignedStudentId(),
            'remark_id' => null,
            'status' => TermPaperStatus::AVAILABLE,
        ]);

        $termPaper->student_id = null;

        $this->assertFalse($teacher->can('claim', $termPaper));
    }
}
