<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('shows a login button to guests', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Login')
        ->assertSee('Your New Car');
});

test('shows the login form', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Welcome Back')
        ->assertSee('Login to your account');
});

test('shows the signed-in name in place of the login button', function () {
    $user = User::factory()->create([
        'name' => 'Ava Lane',
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login.store'), [
        'email' => 'ava@example.com',
        'password' => 'password',
    ])->assertRedirect(route('home'));

    $this->assertAuthenticatedAs($user, 'web');
    $this->assertGuest('admin');

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSeeText('Ava Lane')
        ->assertDontSeeText('Login')
        ->assertSee('toastr.success(', false)
        ->assertSee('Logged in successfully.', false);
});

test('rejects a website login with the wrong password', function () {
    User::factory()->create([
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'ava@example.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);

    $this->assertGuest('web');
    $this->assertGuest('admin');
});

test('rejects an admin account on the website login', function () {
    User::factory()->admin()->create([
        'email' => 'admin@lotbook.test',
        'password' => 'password',
    ]);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'admin@lotbook.test',
            'password' => 'password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'This login is for website accounts. Admin accounts use the admin sign-in.',
        ]);

    $this->assertGuest('web');
    $this->assertGuest('admin');
});

test('requires an email and password to log in', function () {
    $this->from(route('login'))
        ->post(route('login.store'), [])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);

    $this->assertGuest('web');
});

test('does not throttle after multiple failed website login attempts', function () {
    User::factory()->create([
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    foreach (range(1, 6) as $attempt) {
        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'ava@example.com',
                'password' => 'wrong-password',
            ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
    }

    $this->assertGuest('web');
});

test('logs a visitor out and shows the login button again', function () {
    $user = User::factory()->create([
        'name' => 'Ava Lane',
    ]);

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest('web');

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Login')
        ->assertDontSeeText('Ava Lane')
        ->assertSee('toastr.success(', false)
        ->assertSee('Logged out successfully.', false);
});

test('escapes a signed-in name on the homepage', function () {
    $user = User::factory()->create([
        'name' => "Ava <script>alert('xss')</script>",
    ]);

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertOk();
    $response->assertSee('&lt;script&gt;', false);
    $response->assertDontSee("<script>alert('xss')</script>", false);
});
