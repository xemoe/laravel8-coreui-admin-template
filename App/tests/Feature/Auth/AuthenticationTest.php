<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE_AUTH_LOGIN = 'guest.login';
    const ROUTE_AUTH_LOGOUT = 'auth.logout';

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route($this::ROUTE_AUTH_LOGIN));

        $response->assertOk();
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post(route($this::ROUTE_AUTH_LOGIN), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post(route($this::ROUTE_AUTH_LOGIN), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();

        $this->post(route($this::ROUTE_AUTH_LOGIN), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->post(route($this::ROUTE_AUTH_LOGOUT));
        $this->assertGuest();
    }
}
