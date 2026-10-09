<?php

use App\Models\Inspection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('shows a scored checklist for every section', function () {
    $this->get(route('pdi'))
        ->assertOk()
        ->assertSee('Exterior & Body')
        ->assertSee('Tyres & Wheels')
        ->assertSee('Engine Bay & Fluids')
        ->assertSee('Interior & Electronics')
        ->assertSee('Safety Features')
        ->assertSee('Paint condition');
});

test('does not store an inspection for an admin who is not logged in on the website', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('pdi.store'), [
            'brand' => 'Hyundai',
        ])
        ->assertRedirect(route('login'));

    expect(Inspection::query()->count())->toBe(0);
    $this->assertAuthenticatedAs($admin, 'admin');
    $this->assertGuest('web');
});

test('does not store an inspection for a website guest', function () {
    $this->post(route('pdi.store'), [
        'brand' => 'Hyundai',
    ])->assertRedirect(route('login'));

    expect(Inspection::query()->count())->toBe(0);
});

test('saves every section photo and shows the overall rating', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user, 'web');

    $scores = [];

    foreach (array_keys(Inspection::checklistItems()) as $index => $key) {
        $this->post(route('pdi.photo'), [
            'item' => $key,
            'photo' => UploadedFile::fake()->image("{$key}.jpg"),
        ])->assertOk();

        $scores[$key] = ['score' => ($index % 10) + 1];
    }

    $this->post(route('pdi.store'), [
        'brand' => 'DS Automobiles',
        'model_name' => 'DS 7',
        'location' => 'Nagpur',
        'inspector' => 'Dolly Pravin Kankariya',
        'vin' => 'TM5TESTVIN123',
        'inspected_on' => '2026-08-09',
        'items' => $scores,
    ])->assertRedirect();

    $inspection = Inspection::query()->with('items')->first();
    $expected = round(collect($scores)->avg('score'), 1);

    expect($inspection)->not->toBeNull()
        ->and($inspection->items)->toHaveCount(count(Inspection::checklistItems()))
        ->and((float) $inspection->overall_rating)->toBe($expected)
        ->and($inspection->status)->toBe('completed')
        ->and($inspection->user->is($user))->toBeTrue();

    Storage::disk('public')->assertExists($inspection->items->first()->photo);

    $this->get(route('pdi.show', $inspection))
        ->assertOk()
        ->assertSee('Overall Rating')
        ->assertSee('COMPLETED')
        ->assertSee('Dolly Pravin Kankariya')
        ->assertSee(number_format($expected, 1).'/10')
        ->assertSee('Photos ('.$inspection->items->count().')');

    expect(strlen($inspection->getRouteKey()))->toBe(5)
        ->and(parse_url(route('pdi.show', $inspection), PHP_URL_PATH))->not->toBe('/pdi/'.$inspection->getKey());

    $this->get('/pdi/'.$inspection->getKey())->assertNotFound();
});
