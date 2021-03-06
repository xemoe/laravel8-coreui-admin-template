<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersEditPageTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    const ROUTE_AUTH_LOGIN = 'guest.login';
    const ROUTE_AUTH_LOGOUT = 'auth.logout';
    const ROUTE_USERS_EDIT = 'admin.users.edit';
    const ROUTE_USERS_UPDATE = 'admin.users.update';
    const ROUTE_USERS_DESTROY = 'admin.users.destroy';

    public function test_root_user_can_access_users_edit_page()
    {
        $root = User::factory()->create();
        $root->beRootUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($root)
            ->get(route($this::ROUTE_USERS_EDIT, ['user' => $editUser]));

        $resp->assertOk();

        $resp->assertSee($editUser->name);
        $resp->assertSee($editUser->email);
    }

    public function test_root_user_can_change_user_name()
    {
        $root = User::factory()->create();
        $root->beRootUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($root)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'information',
                'name' => 'TestChangeName',
                'role' => 'simple',
                'active' => 'on',
            ]);

        $resp->assertRedirect();

        //
        // Check response from edit page
        //
        $editPage = $this
            ->actingAs($root)
            ->get(route($this::ROUTE_USERS_EDIT, ['user' => $editUser]));

        $editPage->assertOk();
        $editPage->assertSee('TestChangeName');
    }

    public function test_root_user_can_delete_user()
    {
        $root = User::factory()->create();
        $root->beRootUser();

        $deleteUser = User::factory()->create();

        $resp = $this
            ->actingAs($root)
            ->delete(route($this::ROUTE_USERS_DESTROY, ['user' => $deleteUser]), [
                'confirm_delete' => 'on',
            ]);

        $resp->assertRedirect();

        //
        // Check response from edit page
        //
        $editPage = $this
            ->actingAs($root)
            ->get(route($this::ROUTE_USERS_EDIT, ['user' => $deleteUser]));

        $editPage->assertNotFound();
    }

    public function test_admin_user_can_access_users_edit_page()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($admin)
            ->get(route($this::ROUTE_USERS_EDIT, ['user' => $editUser]));

        $resp->assertOk();

        $resp->assertSee($editUser->name);
        $resp->assertSee($editUser->email);
    }

    public function test_admin_user_can_change_user_name()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();

         $this->actingAs($admin)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'information',
                'name' => 'TestChangeName',
                'role' => 'simple',
                'active' => 'on',
            ]);

        $this->assertEquals('TestChangeName', $editUser->fresh()->name);
    }

    public function test_admin_user_can_change_user_role()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();
        $editUser->beAdminUser();

         $this->actingAs($admin)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'information',
                'name' => $editUser->name,
                'role' => 'simple',
                'active' => 'on',
            ]);

        $this->assertTrue($editUser->fresh()->isSimpleUser());
    }

    public function test_admin_user_can_change_user_email()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();

         $this->actingAs($admin)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'email',
                'email' => 'changed_email@example.com',
            ]);

        $this->assertEquals('changed_email@example.com', $editUser->fresh()->email);
    }

    public function test_admin_user_can_change_user_password()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($admin)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'password',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ]);

        $resp->assertRedirect();

        //
        // Logout and login with new password
        //
        $this->post(route($this::ROUTE_AUTH_LOGOUT));
        $this->assertGuest();

         $this->post(route($this::ROUTE_AUTH_LOGIN), [
            'email' => $editUser->email,
            'password' => 'newpassword',
        ]);

        $this->assertAuthenticatedAs($editUser);
    }

    public function test_admin_user_can_deactive_user()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($admin)
            ->put(route($this::ROUTE_USERS_UPDATE, ['user' => $editUser]), [
                'update_form' => 'information',
                'name' => $editUser->name,
                'role' => 'simple',
            ]);

        $resp->assertRedirect();
        $this->assertFalse($editUser->fresh()->isActive());
    }

    public function test_admin_user_can_delete_user()
    {
        $admin = User::factory()->create();
        $admin->beAdminUser();

        $deleteUser = User::factory()->create();

        $resp = $this
            ->actingAs($admin)
            ->delete(route($this::ROUTE_USERS_DESTROY, ['user' => $deleteUser]), [
                'confirm_delete' => 'on',
            ]);

        $resp->assertRedirect();
        $this->assertNull($deleteUser->fresh());
    }

    public function test_simple_user_cannot_access_users_edit_page()
    {
        $simple = User::factory()->create();
        $simple->beSimpleUser();

        $editUser = User::factory()->create();

        $resp = $this
            ->actingAs($simple)
            ->get(route($this::ROUTE_USERS_EDIT, ['user' => $editUser]));

        $resp->assertForbidden();
    }

    public function test_simple_user_cannot_delete_user()
    {
        $simple = User::factory()->create();
        $simple->beSimpleUser();

        $deleteUser = User::factory()->create();

        $resp = $this
            ->actingAs($simple)
            ->delete(route($this::ROUTE_USERS_DESTROY, ['user' => $deleteUser]), [
                'confirm_delete' => 'on',
            ]);

        $resp->assertForbidden();
    }

    public function test_guest_cannot_access_users_edit_page()
    {
        $user = User::factory()->create();
        $resp = $this->get(route($this::ROUTE_USERS_EDIT, ['user' => $user]));

        $resp->assertRedirect(route($this::ROUTE_AUTH_LOGIN));
    }
}
