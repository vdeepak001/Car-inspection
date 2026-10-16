<?php

use App\Models\Inspection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('renders the CarPDI homepage with 5th point linking to verified cars in new tab and no car cards section on home', function () {
    $completedCar = Inspection::factory()->create([
        'brand' => 'MG',
        'model_name' => 'Hector Plus',
        'sale_price' => '₹ 14,75,000',
        'location' => 'Jafar Nagar',
        'status' => 'completed',
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewIs('home');
    $response->assertSeeText('Your New Car');
    $response->assertSee('How It Works');
    $response->assertSee('View Details');
    $response->assertSee(route('pdi.verified'));
    $response->assertSee('target="_blank"', false);
    // Inspected vehicles section removed from home page as requested
    $response->assertDontSee('id="inspected-cars"', false);
    $response->assertDontSee('Inspected Vehicles');
});

test('dedicated verified cars page shows only completed database records without login and opens details in new tab', function () {
    $completedCar = Inspection::factory()->create([
        'brand' => 'Skoda',
        'model_name' => 'Octavia Completed',
        'sale_price' => '₹ 8,90,000',
        'status' => 'completed',
    ]);

    $draftCar = Inspection::factory()->create([
        'brand' => 'Honda',
        'model_name' => 'City Draft Inspection',
        'status' => 'pending',
    ]);

    $response = $this->get(route('pdi.verified'));

    $response->assertOk();
    $response->assertViewIs('pdi.verified');
    $response->assertSee('Verified Inspected Vehicles');
    $response->assertSee('Octavia Completed');
    $response->assertSee('₹ 8,90,000');
    $response->assertSee('target="_blank"', false);
    // Pending status inspections must never be shown
    $response->assertDontSee('City Draft Inspection');
});

test('allows guests to view inspection report details without login', function () {
    $inspection = Inspection::factory()->create([
        'brand' => 'Hyundai',
        'model_name' => 'Creta',
        'overall_rating' => 9.2,
        'status' => 'completed',
    ]);

    // Request as guest (no authentication)
    $this->get(route('pdi.show', $inspection))
        ->assertOk()
        ->assertSee('Hyundai Creta')
        ->assertSee('9.2/10')
        ->assertSee('Download PDF');
});
