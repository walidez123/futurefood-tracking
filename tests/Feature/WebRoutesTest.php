<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    // Test home route
    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // Add more test methods for other routes...

    // Test about-us route
    public function test_about_us_route()
    {
        $response = $this->get('/about-us');
        $response->assertStatus(200);
    }

    // Test contact-us route
    public function test_contact_us_route()
    {
        $response = $this->get('/contact-us');
        $response->assertStatus(200);
    }

    // ... Add more test methods for other routes ...

    // Test client dashboard route
    public function test_client_dashboard_route()
    {
        $response = $this->get('/client');
        $response->assertStatus(200);
    }

    // Test admin dashboard route
    public function test_admin_dashboard_route()
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    // ... Add more test methods for other routes ...

    // Test super admin dashboard route
    public function test_super_admin_dashboard_route()
    {
        $response = $this->get('/super_admin');
        $response->assertStatus(200);
    }

    // Test supervisor dashboard route
    public function test_supervisor_dashboard_route()
    {
        $response = $this->get('/supervisor');
        $response->assertStatus(200);
    }

    // Test service provider dashboard route
    public function test_service_provider_dashboard_route()
    {
        $response = $this->get('/service_provider');
        $response->assertStatus(200);
    }
}
