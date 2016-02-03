<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;

class JiraControllerTest extends TestCase
{
    /**
     * @test
     */
    public function read_payload()
    {
        $payload = json_decode(File::get(base_path('tests/fixtures/jira_ticket_made.json')), true);

        $payload_model = new \App\JiraPayload();

        $payload_model->setPayload($payload);

        $this->assertEquals('alfrednutile@gmail.com', $payload_model->getCreatorEmail());
        $this->assertEquals('alfrednutile@gmail.com', $payload_model->getReporterEmail());
        $this->assertEquals('alfrednutile@gmail.com', $payload_model->getAssigneeEmail());
        $this->assertEquals('alfrednutile@gmail.com', $payload_model->getUserEmail());

    }

    /**
     * @test
     */
    public function matching_user_in_payload()
    {
        $payload = json_decode(File::get(base_path('tests/fixtures/jira_ticket_made.json')), true);

        $payload_model = new \App\JiraPayload();

        $payload_model->setPayload($payload);

        $this->assertTrue($payload_model->userOnTeam($payload_model->getReporterEmail()));

    }

    /**
     * @test
     */
    public function returns_messages()
    {
        $payload = json_decode(File::get(base_path('tests/fixtures/jira_ticket_made.json')), true);

        $payload_model = new \App\JiraPayload();

        $payload_model->setPayload($payload);

        $this->assertEquals('Update -- Issue: Testing hooks Link: https://smscvt.atlassian.net/browse/CATCDADOPT-19 Status: Backlog', $payload_model->makeIssueUpdatedMessage());
    }

    /**
     * @test
     */
    public function return_slack_payload()
    {
        $payload = json_decode(File::get(base_path('tests/fixtures/jira_ticket_made.json')), true);

        $results = $this->call('POST', '/api/v1/jira', $payload);

    }
}
