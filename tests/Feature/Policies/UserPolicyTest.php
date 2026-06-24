<?php

namespace Tests\Feature\Policies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_passes_every_ability_via_before_hook(): void
    {
        $admin = User::factory()->admin()->create();
        $otherUser = User::factory()->student()->create();

        $this->assertTrue($admin->can('view', $otherUser));
        $this->assertTrue($admin->can('update', $otherUser));
        $this->assertTrue($admin->can('delete', $otherUser));
        $this->assertTrue($admin->can('create', User::class));
        $this->assertTrue($admin->can('changeRole', $otherUser));
    }

    public function test_view_teachers_is_accessible_to_any_role(): void
    {
        $student = User::factory()->student()->create();
        $professor = User::factory()->professor()->create();
        $dean = User::factory()->dean()->create();

        $this->assertTrue($student->can('viewTeachers', User::class));
        $this->assertTrue($professor->can('viewTeachers', User::class));
        $this->assertTrue($dean->can('viewTeachers', User::class));
    }

    public function test_view_students_is_restricted_to_rector_only(): void
    {
        $rector = User::factory()->rector()->create();
        $dean = User::factory()->dean()->create();
        $professor = User::factory()->professor()->create();

        $this->assertTrue($rector->can('viewStudents', User::class));
        $this->assertFalse($dean->can('viewStudents', User::class));
        $this->assertFalse($professor->can('viewStudents', User::class));
    }

    public function test_admin_reaches_view_students_only_through_before_hook(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->can('viewStudents', User::class));
    }

    public function test_create_is_always_false_for_non_admin(): void
    {
        $rector = User::factory()->rector()->create();

        $this->assertFalse($rector->can('create', User::class));
    }

    public function test_change_role_is_always_false_for_non_admin(): void
    {
        $rector = User::factory()->rector()->create();
        $otherUser = User::factory()->professor()->create();

        $this->assertFalse($rector->can('changeRole', $otherUser));
    }

    public function test_user_cannot_delete_themselves(): void
    {
        $rector = User::factory()->rector()->create();

        $this->assertFalse($rector->can('delete', $rector));
    }

    public function test_force_delete_is_never_allowed_for_non_admin(): void
    {
        $rector = User::factory()->rector()->create();
        $otherUser = User::factory()->student()->create();

        $this->assertFalse($rector->can('forceDelete', $otherUser));
    }
}
