<?php

use App\Models\Inspection;
use App\Models\InspectionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        ->assertSeeText('Completed');

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

test('allows admin to update inspection status between pending and completed', function () {
    $admin = User::factory()->admin()->create();
    $inspection = Inspection::factory()->create([
        'status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.inspections.status', $inspection), [
            'status' => 'completed',
        ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Inspection status updated to Completed.');

    expect($inspection->fresh()->status)->toBe('completed');

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.inspections.status', $inspection), [
            'status' => 'pending',
        ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Inspection status updated to Pending.');

    expect($inspection->fresh()->status)->toBe('pending');
});

test('prevents guests and regular members from updating inspection status', function () {
    $member = User::factory()->create();
    $inspection = Inspection::factory()->create([
        'status' => 'pending',
    ]);

    // Guest
    $this->patch(route('admin.inspections.status', $inspection), [
        'status' => 'completed',
    ])->assertRedirect(route('admin.login'));

    expect($inspection->fresh()->status)->toBe('pending');

    // Regular web member
    $this->actingAs($member, 'web')
        ->patch(route('admin.inspections.status', $inspection), [
            'status' => 'completed',
        ])
        ->assertRedirect(route('admin.login'));

    expect($inspection->fresh()->status)->toBe('pending');
});

test('validates status parameter when updating inspection status', function () {
    $admin = User::factory()->admin()->create();
    $inspection = Inspection::factory()->create([
        'status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.inspections.status', $inspection), [
            'status' => 'invalid_status',
        ])
        ->assertSessionHasErrors(['status']);

    expect($inspection->fresh()->status)->toBe('pending');
});

test('allows admin to update inspection details card', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $inspection = Inspection::factory()->create([
        'brand' => 'Old Brand',
        'model_name' => 'Old Model',
        'status' => 'pending',
    ]);

    $rcFront = UploadedFile::fake()->image('rc_front.jpg');
    $rcBack = UploadedFile::fake()->image('rc_back.jpg');
    $insurance = UploadedFile::fake()->image('insurance.jpg');

    $this->actingAs($admin, 'admin')
        ->put(route('admin.inspections.update', $inspection), [
            'brand' => 'Updated Brand',
            'model_name' => 'Updated Model',
            'vehicle_variant' => 'ZXi Plus',
            'vehicle_number' => 'MH31AB1234',
            'chassis_number' => '1HGCR2F83HA123456',
            'engine_number' => 'ENG98765',
            'location' => 'Nagpur East',
            'rto_location' => 'Nagpur City',
            'inspector' => 'Admin Inspector',
            'inspected_on' => '2026-10-15',
            'status' => 'completed',
            'rc_status' => 'Available',
            'rc_valid_until' => '2030-05-20',
            'rc_front_photo' => $rcFront,
            'rc_back_photo' => $rcBack,
            'insurance_type' => 'Comprehensive',
            'insurance_valid_until' => '2027-10-15',
            'insurance_photo' => $insurance,
            'customer_name' => 'Jane Doe',
            'file_number' => 'FILE-001',
            'approx_expense' => '₹15,000',
            'market_value' => '₹8,50,000',
            'sale_price' => '₹7,90,000',
            'remark' => 'Clean car overall.',
        ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Inspection details updated successfully.');

    $inspection->refresh();

    expect($inspection->brand)->toBe('Updated Brand')
        ->and($inspection->model_name)->toBe('Updated Model')
        ->and($inspection->vehicle_variant)->toBe('ZXi Plus')
        ->and($inspection->vehicle_number)->toBe('MH31AB1234')
        ->and($inspection->chassis_number)->toBe('1HGCR2F83HA123456')
        ->and($inspection->vin)->toBe('1HGCR2F83HA123456')
        ->and($inspection->engine_number)->toBe('ENG98765')
        ->and($inspection->location)->toBe('Nagpur East')
        ->and($inspection->rto_location)->toBe('Nagpur City')
        ->and($inspection->inspector)->toBe('Admin Inspector')
        ->and($inspection->status)->toBe('completed')
        ->and($inspection->rc_status)->toBe('Available')
        ->and($inspection->customer_name)->toBe('Jane Doe')
        ->and($inspection->file_number)->toBe('FILE-001')
        ->and($inspection->approx_expense)->toBe('₹15,000')
        ->and($inspection->market_value)->toBe('₹8,50,000')
        ->and($inspection->sale_price)->toBe('₹7,90,000')
        ->and($inspection->remark)->toBe('Clean car overall.');

    Storage::disk('public')->assertExists($inspection->rc_front_photo);
    Storage::disk('public')->assertExists($inspection->rc_back_photo);
    Storage::disk('public')->assertExists($inspection->insurance_photo);
});

test('allows admin to update checklist item card and recalculates overall rating', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $inspection = Inspection::factory()->create([
        'overall_rating' => 5.0,
    ]);

    $item1 = InspectionItem::factory()->for($inspection)->create([
        'item_key' => 'exterior_paint',
        'label' => 'Paint condition — all panels',
        'section' => 'Exterior & Body',
        'score' => 4,
        'photo' => 'pdi/old_paint.jpg',
    ]);

    $item2 = InspectionItem::factory()->for($inspection)->create([
        'item_key' => 'exterior_glass',
        'label' => 'Windshield & window glass',
        'section' => 'Exterior & Body',
        'score' => 6,
        'photo' => 'pdi/old_glass.jpg',
    ]);

    $newPhoto = UploadedFile::fake()->image('new_paint.jpg');

    $this->actingAs($admin, 'admin')
        ->put(route('admin.inspections.items.update', [$inspection, 'exterior_paint']), [
            'score' => 10,
            'label' => 'Paint condition — Flawless',
            'section' => 'Exterior & Body',
            'photo' => $newPhoto,
        ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Checklist item "Paint condition — Flawless" updated successfully.');

    $item1->refresh();
    $inspection->refresh();

    expect($item1->score)->toBe(10)
        ->and($item1->label)->toBe('Paint condition — Flawless');

    Storage::disk('public')->assertExists($item1->photo);

    // Average of 10 and 6 = 8.0
    expect((float) $inspection->overall_rating)->toBe(8.0);
});

test('prevents guests and members from updating inspection details and items', function () {
    $member = User::factory()->create();
    $inspection = Inspection::factory()->create(['brand' => 'Original Brand']);

    // Guest updating details
    $this->put(route('admin.inspections.update', $inspection), [
        'brand' => 'Hacked',
        'model_name' => 'Hacked',
        'location' => 'Hacked',
        'inspector' => 'Hacked',
        'status' => 'completed',
    ])->assertRedirect(route('admin.login'));

    // Member updating details
    $this->actingAs($member, 'web')
        ->put(route('admin.inspections.update', $inspection), [
            'brand' => 'Hacked',
            'model_name' => 'Hacked',
            'location' => 'Hacked',
            'inspector' => 'Hacked',
            'status' => 'completed',
        ])->assertRedirect(route('admin.login'));

    expect($inspection->fresh()->brand)->toBe('Original Brand');

    // Guest updating item
    $this->put(route('admin.inspections.items.update', [$inspection, 'exterior_paint']), [
        'score' => 1,
    ])->assertRedirect(route('admin.login'));

    // Member updating item
    $this->actingAs($member, 'web')
        ->put(route('admin.inspections.items.update', [$inspection, 'exterior_paint']), [
            'score' => 1,
        ])->assertRedirect(route('admin.login'));
});
