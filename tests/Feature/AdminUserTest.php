<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('creates a website account from the admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('status', 'User created.');

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('toastr.success(', false)
        ->assertSee('User created.', false)
        ->assertDontSee('alert alert-success', false);

    $user = User::query()->where('email', 'ava@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Ava Lane')
        ->and($user->phone)->toBe('5551234567')
        ->and($user->is_admin)->toBeFalse()
        ->and($user->password)->not->toBe('password');

    expect(Hash::check('password', $user->password))->toBeTrue();

    $this->app['auth']->forgetGuards();

    $this->post(route('login.store'), [
        'email' => 'ava@example.com',
        'password' => 'password',
    ])->assertRedirect(route('home'));

    $this->get(route('home'))
        ->assertOk()
        ->assertSeeText('Ava Lane')
        ->assertDontSeeText('Login');
});

test('does not grant admin access from the create user form', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_admin' => true,
        ])
        ->assertRedirect(route('admin.dashboard'));

    expect(User::query()->where('email', 'ava@example.com')->first()->is_admin)->toBeFalse();
});

test('requires a name, phone, email, and password when creating a user', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'), [])
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'phone' => 'The phone field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);

    expect(User::query()->count())->toBe(1);
});

test('rejects a password that does not match the confirmation', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'different',
        ])
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors([
            'password' => 'The password field confirmation does not match.',
        ]);

    $this->assertDatabaseMissing('users', [
        'email' => 'ava@example.com',
    ]);
});

test('rejects a password shorter than 8 characters', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors([
            'password' => 'The password field must be at least 8 characters.',
        ]);
});

test('rejects a phone number that is not a phone number', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => 'not-a-phone',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors([
            'phone' => 'Enter a valid phone number.',
        ]);
});

test('rejects an email that is already registered', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->create([
        'email' => 'ava@example.com',
    ]);

    $this->actingAs($admin, 'admin')
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors([
            'email' => 'The email has already been taken.',
        ]);
});

test('sends guests to the admin login when they try to create a user', function () {
    $this->post(route('admin.users.store'), [
        'name' => 'Ava Lane',
        'phone' => '5551234567',
        'email' => 'ava@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('admin.login'));

    $this->assertDatabaseMissing('users', [
        'email' => 'ava@example.com',
    ]);
});

test('forbids a website account from creating a user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('admin.users.store'), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('admin.login'));

    $this->assertDatabaseMissing('users', [
        'email' => 'ava@example.com',
    ]);
});

test('shows the add user form', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertSee('Create a user')
        ->assertSee('>Show<', false);
});

test('shows an account without revealing the saved password', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create([
        'name' => 'Ava Lane',
        'phone' => '5551234567',
        'password' => 'password',
    ]);

    $this->actingAs($admin, 'admin')
        ->get(route('admin.users.show', $user))
        ->assertOk()
        ->assertSeeText('Ava Lane')
        ->assertSee('5551234567')
        ->assertSee('Hidden. Saved passwords cannot be shown.')
        ->assertDontSee($user->password, false);
});

test('updates a user and replaces the password', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.users.update', $user), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
            'is_admin' => true,
        ])
        ->assertRedirect(route('admin.users.show', $user))
        ->assertSessionHas('status', 'User updated.');

    $user->refresh();

    expect($user->name)->toBe('Ava Lane')
        ->and($user->phone)->toBe('5551234567')
        ->and($user->is_admin)->toBeFalse();

    expect(Hash::check('new-password', $user->password))->toBeTrue();
    expect(Hash::check('password', $user->password))->toBeFalse();
});

test('keeps the current password when the edit form leaves it blank', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create([
        'email' => 'ava@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.users.update', $user), [
            'name' => 'Ava Lane',
            'phone' => '5551234567',
            'email' => 'ava@example.com',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('admin.users.show', $user));

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});

test('deletes a website user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create([
        'email' => 'ava@example.com',
    ]);

    $this->actingAs($admin, 'admin')
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('status', 'User deleted.');

    $this->assertDatabaseMissing('users', [
        'email' => 'ava@example.com',
    ]);
});

test('does not delete the signed-in admin', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->from(route('admin.dashboard'))
        ->delete(route('admin.users.destroy', $admin))
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHasErrors([
            'user' => 'You cannot delete the account you are signed in with.',
        ]);

    $this->assertModelExists($admin);
});
