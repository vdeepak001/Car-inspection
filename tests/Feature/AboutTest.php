<?php

test('shows the about us page with mangal finance group details', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Mangal Finance Group')
        ->assertSee('FINANCING HAPPINESS')
        ->assertSee('Mr. Dilip Ranka')
        ->assertSee('Mr. Sachin Soni')
        ->assertSee('MANGAL VEHICLE FINANCE PVT LTD')
        ->assertSee('DEEKAY CARS')
        ->assertSee('DEEKAY MOTORS')
        ->assertSee('MANGAL DEVELOPERS')
        ->assertSee('MISSRI VECHFIN LINKS')
        ->assertSee('Our 8-Step Process Flow');
});
