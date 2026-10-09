<?php

use App\Models\Inspection;
use App\Models\InspectionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('sends guests from the inspection list to the admin login', function () {
    $this->get(route('admin.inspections.index'))
        ->assertRedirect(route('admin.login'));
});

test('keeps a website account out of the inspection list', function () {
    $member = User::factory()->create();

    $this->actingAs($member, 'web')
        ->get(route('admin.inspections.index'))
        ->assertRedirect(route('admin.login'));
});

test('shows the website account and every inspection photo', function () {
    $admin = User::factory()->admin()->create();
    $member = User::factory()->create([
        'name' => 'Ava Lane',
        'phone' => '5551234567',
        'email' => 'ava@example.com',
    ]);

    $inspection = Inspection::factory()->for($member)->create([
        'brand' => 'DS Automobiles',
        'model_name' => 'DS 7',
        'location' => 'Nagpur',
        'inspector' => 'Dolly Pravin Kankariya',
        'vin' => 'TM5TESTVIN123',
        'engine_number' => 'ENG12345',
        'inspected_on' => '2026-08-09',
        'overall_rating' => 8.0,
        'status' => 'completed',
    ]);

    InspectionItem::factory()->for($inspection)->create([
        'section' => 'Exterior & Body',
        'item_key' => 'exterior_paint',
        'label' => 'Paint condition — all panels',
        'score' => 8,
        'photo' => 'pdi/exterior-paint.jpg',
    ]);

    InspectionItem::factory()->for($inspection)->create([
        'section' => 'Safety Features',
        'item_key' => 'safety_horn',
        'label' => 'Horn & wipers',
        'score' => 6,
        'photo' => 'pdi/safety-horn.jpg',
    ]);

    $this->actingAs($admin, 'admin')
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSeeText('Inspections');

    $this->get(route('admin.inspections.index'))
        ->assertOk()
        ->assertSeeText('Ava Lane')
        ->assertSeeText('5551234567')
        ->assertSeeText('ava@example.com')
        ->assertSeeText('DS Automobiles')
        ->assertSeeText('DS 7')
        ->assertSeeText('Nagpur')
        ->assertSeeText('Dolly Pravin Kankariya')
        ->assertSeeText('TM5TESTVIN123')
        ->assertSeeText('09 Aug 2026')
        ->assertSeeText('8.0/10')
        ->assertSeeText('completed');

    $this->get(route('admin.inspections.show', $inspection))
        ->assertOk()
        ->assertSeeText('Ava Lane')
        ->assertSeeText('5551234567')
        ->assertSeeText('ava@example.com')
        ->assertSeeText('Member')
        ->assertSeeText('ENG12345')
        ->assertSeeText('Paint condition — all panels')
        ->assertSeeText('Horn & wipers')
        ->assertSeeText('8/10')
        ->assertSeeText('6/10')
        ->assertSee('storage/pdi/exterior-paint.jpg', false)
        ->assertSee('storage/pdi/safety-horn.jpg', false)
        ->assertSeeText('Windshield & window glass')
        ->assertSeeText('Not recorded');
});
