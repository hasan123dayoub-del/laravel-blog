<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get(route('admin.blogs.index'))->assertRedirect(route('login.form'));
    }

    public function test_regular_users_can_not_open_the_admin_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.blogs.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.categories.index'))->assertForbidden();
    }

    public function test_admins_can_manage_blogs_and_categories(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.blogs.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.categories.index'))->assertOk();
    }
}
