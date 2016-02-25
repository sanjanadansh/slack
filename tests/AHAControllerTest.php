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

        $this->assertEquals("Example Incoming Feature from AHA: Created by Ani Gupta, URL https://det.aha.io:443/features/ALTEST-1, Assigned to Al Nutile, Status Under consideration", $payload_model->makeSlackMessage());

        //$this->post('/api/v1/aha', $payload);
    }

    /**
     * @test
     */
    public function convert_release_to_payload()
    {
        $payload = File::get(base_path('tests/fixtures/aha_release_payload.json'));

        $payload = json_decode($payload, true);

        $payload_model = new \App\AHAPayload();

        $payload_model->setType('release')->setPayload($payload);

        $this->assertEquals('https://det.aha.io:443/releases/ALTEST-R-2', $payload_model->getUrl());

        $this->assertEquals('Under consideration', $payload_model->getWorkflowStatus());


        $this->assertEquals("Example Incoming Release from AHA: URL https://det.aha.io:443/releases/ALTEST-R-2, Owner to Al Nutile, Status Under consideration", $payload_model->makeSlackMessage());

        //$this->post('/api/v1/aha', $payload);
    }
}
