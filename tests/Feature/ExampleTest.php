<?php

test('renders the CarPDI homepage', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewIs('home');
    $response->assertSeeText('Your New Car');
    $response->assertSee('How It Works');
    $response->assertSee('Detailed Inspection');
    $response->assertDontSee('id="theme-toggle"', false);
});
