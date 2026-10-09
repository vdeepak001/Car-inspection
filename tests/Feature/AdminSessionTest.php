<?php

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('sends guests from the dashboard to the admin login', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('shows the admin login form', function () {
    $this->get(route('admin.login'))
        ->assertOk()
        ->assertSee('Admin panel')
        ->assertSee('This door is only for the admin account.')
        ->assertSee('Switch to dark theme', false);
});

test('opens the dashboard for the seeded admin without signing in on the website', function () {
    $this->seed(AdminSeeder::class);

    $this->post(route('admin.login.store'), [
        'email' => 'admin@lotbook.test',
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $admin = User::query()->where('email', 'admin@lotbook.test')->first();

    $this->assertAuthenticatedAs($admin, 'admin');
    $this->assertGuest('web');

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Add user')
        ->assertSee('images/admin-avatar.svg', false)
        ->assertDontSee('Confirm password')
        ->assertSeeText('Lotbook Admin')
        ->assertSee('navbar-vertical', false)
        ->assertSee('Switch to dark theme', false)
        ->assertSee('toastr.success(', false)
        ->assertSee('Logged in successfully.', false);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Login')
        ->assertDontSeeText('Lotbook Admin');
});

test('rejects a website account on the admin login', function () {
    User::factory()->create([
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    $this->from(route('admin.login'))
        ->post(route('admin.login.store'), [
            'email' => 'ava@example.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors([
            'email' => 'These credentials are not for the admin panel.',
        ]);

    $this->assertGuest('admin');
    $this->assertGuest('web');
});

test('keeps a website session out of the admin dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'web')
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));

    $this->assertAuthenticatedAs($user, 'web');
    $this->assertGuest('admin');
});

test('forbids a non-admin on the admin guard', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'admin')
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('logs an admin out of the admin panel only', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest('admin');

    $this->get(route('admin.login'))
        ->assertOk()
        ->assertSee('toastr.success(', false)
        ->assertSee('Logged out successfully.', false);
});
