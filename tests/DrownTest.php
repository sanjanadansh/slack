<?php

use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DrownTest extends TestCase
{
    /**
     * @test
     */
    public function drown()
    {
        /**
         * Take incoming request
         * Find words given in the github docs
         *
         * @TODO setup Cache https://github.com/KnpLabs/php-github-api#cache-usage
         */

        $post = ['text' => 'alfrednutile.info'];
        $results = $this->call('POST', '/api/v1/drown', $post);

        $this->assertResponseOk();


        dd(json_decode($results->getContent(), true));


    }
}
