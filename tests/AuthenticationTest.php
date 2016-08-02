<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{

    public function testMeasurementAsGuest()
    {
        $this->get('/v1/measurement');

        $this->assertEquals(
            401, $this->response->status()
        );
    }

    public function testMeasurementAsDevice()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        $this->get('/v1/measurement');

        $this->assertEquals(
            200, $this->response->status()
        );
    }

    public function testMeasurementAsDeviceWithToken()
    {
        $user = factory(App\User::class)->create();
        $token = factory(App\Token::class)->make()->fill(['expired_at' => null]);
        $user->tokens()->save($token);

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
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        $this->get('/v1/device');

        $this->assertEquals(
            200, $this->response->status()
        );
    }

    public function testDeviceAsDeviceWithToken()
    {
        $user = factory(App\User::class)->create();
        $token = factory(App\Token::class)->make()->fill(['expired_at' => null]);
        $user->tokens()->save($token);

        $response = $this->call('GET', '/v1/device', ['api_token' => $token->content]);
        $this->assertEquals(
            200, $response->status()
        );
    }
}
