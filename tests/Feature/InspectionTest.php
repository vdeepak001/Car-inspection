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
        ->assertSee('Paint condition')
        ->assertSee('00/10');
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

test('shows custom brand and location options on the pdi form', function () {
    $this->get(route('pdi'))
        ->assertOk()
        ->assertSee('+ Other (Add new brand)')
        ->assertSee('+ Other (Add new location)')
        ->assertSee('data-custom-box="brand"', false)
        ->assertSee('data-custom-box="location"', false);
});

test('saves an inspection with custom other brand and location via custom inputs', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user, 'web');

    $scores = [];
    foreach (array_keys(Inspection::checklistItems()) as $key) {
        $this->post(route('pdi.photo'), [
            'item' => $key,
            'photo' => UploadedFile::fake()->image("{$key}.jpg"),
        ])->assertOk();

        $scores[$key] = ['score' => 9];
    }

    $this->post(route('pdi.store'), [
        'brand' => '__other__',
        'brand_custom' => 'Volkswagen',
        'model_name' => 'Taigun',
        'location' => '__other__',
        'location_custom' => 'Chandigarh',
        'inspector' => 'Special Inspector',
        'vin' => 'VWTESTVIN123456',
        'inspected_on' => '2026-10-16',
        'items' => $scores,
    ])->assertRedirect();

    $inspection = Inspection::query()->latest()->first();

    expect($inspection)->not->toBeNull()
        ->and($inspection->brand)->toBe('Volkswagen')
        ->and($inspection->location)->toBe('Chandigarh');
});

test('can store and retrieve dynamic dropdown options via options endpoint', function () {
    $this->postJson(route('pdi.options'), [
        'category' => 'brand',
        'name' => 'Tesla',
    ])->assertOk()
        ->assertJson([
            'category' => 'brand',
            'name' => 'Tesla',
        ]);

    $this->assertDatabaseHas('inspection_options', [
        'category' => 'brand',
        'name' => 'Tesla',
    ]);

    $this->get(route('pdi'))
        ->assertOk()
        ->assertSee('Tesla');
});

test('validates chassis number is a unique 17 character alphanumeric string', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'web');

    // Too short (16 chars)
    $this->post(route('pdi.store'), [
        'chassis_number' => '1234567890123456',
        'brand' => 'Tata',
        'model_name' => 'Nexon',
        'location' => 'Nagpur',
        'inspector' => 'Dolly',
        'inspected_on' => '2026-10-16',
        'items' => [],
    ])->assertSessionHasErrors(['chassis_number']);

    // Non-alphanumeric
    $this->post(route('pdi.store'), [
        'chassis_number' => '1234567890123456@',
        'brand' => 'Tata',
        'model_name' => 'Nexon',
        'location' => 'Nagpur',
        'inspector' => 'Dolly',
        'inspected_on' => '2026-10-16',
        'items' => [],
    ])->assertSessionHasErrors(['chassis_number']);

    // Valid 17-char chassis number succeeds
    Storage::fake('public');
    $scores = [];
    foreach (array_keys(Inspection::checklistItems()) as $key) {
        $this->post(route('pdi.photo'), [
            'item' => $key,
            'photo' => UploadedFile::fake()->image("{$key}.jpg"),
        ])->assertOk();
        $scores[$key] = ['score' => 9];
    }

    $this->post(route('pdi.store'), [
        'chassis_number' => 'mat612456n1234567', // lowercase input should be uppercased
        'brand' => 'Tata',
        'model_name' => 'Nexon',
        'location' => 'Nagpur',
        'inspector' => 'Dolly',
        'inspected_on' => '2026-10-16',
        'items' => $scores,
    ])->assertRedirect();

    $inspection = Inspection::query()->latest()->first();
    expect($inspection)->not->toBeNull()
        ->and($inspection->chassis_number)->toBe('MAT612456N1234567');

    // Duplicate chassis number should fail
    $this->post(route('pdi.store'), [
        'chassis_number' => 'MAT612456N1234567',
        'brand' => 'Tata',
        'model_name' => 'Harrier',
        'location' => 'Nagpur',
        'inspector' => 'Dolly',
        'inspected_on' => '2026-10-16',
        'items' => $scores,
    ])->assertSessionHasErrors(['chassis_number']);
});

test('stores all vehicle details and uploaded rc and insurance files', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user, 'web');

    $scores = [];
    foreach (array_keys(Inspection::checklistItems()) as $key) {
        $this->post(route('pdi.photo'), [
            'item' => $key,
            'photo' => UploadedFile::fake()->image("{$key}.jpg"),
        ])->assertOk();
        $scores[$key] = ['score' => 8];
    }

    $rcFront = UploadedFile::fake()->create('rc_front.pdf', 500, 'application/pdf');
    $rcBack = UploadedFile::fake()->image('rc_back.jpg');
    $insuranceFile = UploadedFile::fake()->create('insurance_policy.pdf', 300, 'application/pdf');

    $response = $this->post(route('pdi.store'), [
        'inspector' => 'Special Inspector',
        'brand' => 'Hyundai',
        'model_name' => 'Creta',
        'vehicle_number' => 'MH 31 EV 8899',
        'chassis_number' => 'MALC541CAM1234567',
        'vehicle_variant' => 'SX(O) Turbo',
        'rc_status' => 'Available',
        'rc_valid_until' => '2030-05-15',
        'rc_front' => $rcFront,
        'rc_back' => $rcBack,
        'insurance_type' => 'Comprehensive',
        'insurance_valid_until' => '2027-05-14',
        'insurance_file' => $insuranceFile,
        'approx_expense' => '₹ 15,000',
        'market_value' => '₹ 14,50,000',
        'sale_price' => '₹ 15,00,000',
        'file_number' => 'FILE-9921',
        'rto_location' => 'MH-31 Nagpur East',
        'customer_name' => 'Rajesh Sharma',
        'remark' => 'Excellent vehicle condition. Minor tyre wear.',
        'location' => 'Nagpur',
        'inspected_on' => '2026-10-16',
        'items' => $scores,
    ]);

    $response->assertRedirect();

    $inspection = Inspection::query()->latest()->first();
    expect($inspection)->not->toBeNull()
        ->and($inspection->vehicle_number)->toBe('MH 31 EV 8899')
        ->and($inspection->chassis_number)->toBe('MALC541CAM1234567')
        ->and($inspection->vehicle_variant)->toBe('SX(O) Turbo')
        ->and($inspection->rc_status)->toBe('Available')
        ->and($inspection->rc_valid_until?->format('Y-m-d'))->toBe('2030-05-15')
        ->and($inspection->insurance_type)->toBe('Comprehensive')
        ->and($inspection->insurance_valid_until?->format('Y-m-d'))->toBe('2027-05-14')
        ->and($inspection->customer_name)->toBe('Rajesh Sharma')
        ->and($inspection->approx_expense)->toBe('₹ 15,000')
        ->and($inspection->file_number)->toBe('FILE-9921')
        ->and($inspection->rto_location)->toBe('MH-31 Nagpur East')
        ->and($inspection->remark)->toContain('Excellent vehicle condition')
        ->and($inspection->rc_front_photo)->not->toBeNull()
        ->and($inspection->rc_back_photo)->not->toBeNull()
        ->and($inspection->insurance_photo)->not->toBeNull();

    Storage::disk('public')->assertExists($inspection->rc_front_photo);
    Storage::disk('public')->assertExists($inspection->rc_back_photo);
    Storage::disk('public')->assertExists($inspection->insurance_photo);

    $this->get(route('pdi.show', $inspection))
        ->assertOk()
        ->assertSee('MH 31 EV 8899')
        ->assertSee('MALC541CAM1234567')
        ->assertSee('SX(O) Turbo')
        ->assertSee('Available')
        ->assertSee('Comprehensive')
        ->assertSee('Rajesh Sharma')
        ->assertSee('RC Front Document')
        ->assertSee('RC Back Document')
        ->assertSee('Insurance Document');
});
