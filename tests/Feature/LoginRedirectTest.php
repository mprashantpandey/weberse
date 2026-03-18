<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_login_redirects_to_client_dashboard(): void
    {
        Role::findOrCreate(UserRole::Client->value, 'web');

        $user = User::factory()->create([
            'email' => 'client-login@example.test',
            'password' => 'password',
        ]);
        $user->assignRole(UserRole::Client->value);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('client.dashboard'));
    }
}
