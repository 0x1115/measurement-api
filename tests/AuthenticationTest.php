<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    public function testMeasurementAsGuest()
    {
        $this->get('/v1/measurement');

        $this->assertEquals(
            401, $this->response->status()
        );
    }

    public function testMeasurementAsDevice()
    {
        $device = factory(App\Device::class)->create();

        $this->actingAs($device);

        $this->get('/v1/measurement');

        $this->assertEquals(
            200, $this->response->status()
        );
    }

    public function testMeasurementAsDeviceWithToken()
    {
        $device = factory(App\Device::class)->create();
        $token = factory(App\Token::class)->make()->fill(['expired_at' => null]);
        $device->tokens()->save($token);

        $response = $this->call('GET', '/v1/measurement', ['api_token' => $token->content]);
        $this->assertEquals(
            200, $response->status()
        );
    }

    public function testDeviceAsGuest()
    {
        $this->get('/v1/device');

        $this->assertEquals(
            401, $this->response->status()
        );
    }

    public function testDeviceAsDevice()
    {
        $device = factory(App\Device::class)->create();

        $this->actingAs($device);

        $this->get('/v1/device');

        $this->assertEquals(
            200, $this->response->status()
        );
    }

    public function testDeviceAsDeviceWithToken()
    {
        $device = factory(App\Device::class)->create();
        $token = factory(App\Token::class)->make()->fill(['expired_at' => null]);
        $device->tokens()->save($token);

        $response = $this->call('GET', '/v1/device', ['api_token' => $token->content]);
        $this->assertEquals(
            200, $response->status()
        );
    }
}
