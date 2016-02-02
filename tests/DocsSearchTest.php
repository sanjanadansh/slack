<?php

use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocsSearchTest extends TestCase
{
    /**
     * @test
     */
    public function search_in_docs()
    {
        /**
         * Take incoming request
         * Find words given in the github docs
         *
         * @TODO setup Cache https://github.com/KnpLabs/php-github-api#cache-usage
         */

        $post = ['text' => 'Behat ephemeral'];
        $results = $this->call('POST', '/api/v1/internal_docs', $post);

        $this->assertResponseOk();


        dd(json_decode($results->getContent(), true));


    }
}
