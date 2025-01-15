<?php

namespace Tests\Feature;

use Tests\TestCase;

class CarbonFootprintRequestTest extends TestCase
{
    /**
     * Tests a successful request to calculate carbon footprint.
     * @return void
     */
    public function test_request_successful_calculation()
    {
        $payload = [
            'transport' => [
                ['type' => 'car', 'distance' => 120, 'efficiency' => 15, 'factor' => 2.31],
                ['type' => 'bus', 'distance' => 50, 'efficiency' => 8, 'factor' => 0.05],
            ],
            'electricity' => 100,
            'electricity_factor' => 0.5,
            'diet' => 'vegetarian',
            'consumption' => 200,
            'waste' => 30,
        ];

        $response = $this->postJson('/api/calculate', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'transport_emissions',
            'electricity_emissions',
            'diet_emissions',
            'consumption_emissions',
            'waste_emissions',
            'total_emissions',
        ]);
    }

    /**
     * Tests a request with a validation error (missing data).
     * @return void
     */
    public function test_request_validation_error()
    {

        // Missing 'efficiency' and 'waste'
        $payload = [
            'transport' => [
                ['type' => 'car', 'distance' => 100, 'factor' => 2.31],
            ],
            'electricity' => 150,
            'electricity_factor' => 0.5,
            'diet' => 'omnivorous',
            'consumption' => 200,
        ];

        $response = $this->postJson('/api/calculate', $payload);
        $response->assertStatus(422);
    }
}
