<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $version = config('app.version');

        $this->get('/');

        $this->assertEquals(
            "Measurement API v{$version}", $this->response->getContent()
        );
    }
}
