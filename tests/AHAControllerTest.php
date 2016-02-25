<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;

class AHAControllerTest extends TestCase
{
    /**
     * @test
     */
    public function convert_payload()
    {
        $payload = File::get(base_path('tests/fixtures/aha_payload.json'));

        $payload = json_decode($payload, true);

        $payload_model = new \App\AHAPayload();

        $payload_model->setPayload($payload);

        $this->assertEquals('Ani Gupta', $payload_model->getCreatedBy());
        $this->assertEquals('What does Aha metadata look like', $payload_model->getFeatureName());


        //$this->post('/api/v1/aha', $payload);
    }
}
