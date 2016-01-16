<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client as GoutteClient;

class BritToUSControllerTest extends TestCase
{

    /**
     * @test
     */
    public function play_around_with_goutte()
    {


        $client = new GoutteClient();

        $crawler    = $client->request('GET', 'http://www.translatebritish.com/');
        $form       = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

        $crawler    = $client->submit($form,
            array('p' => 'ye barmy bloke yank in a chivvy'));

        $results = $crawler->siblings()->filter('.translation-text')->text();

        $this->assertEquals("you idiotic guy american in a hurry ", $results);
    }
    

    /**
     * @test
     */
    public function test_britToUs()
    {
        $post = [
            'source' => "ye barmy bloke yank in a chivvy"
        ];

       $this->post("/api/v1/brit_to_us", $post)->seeJson(['data' => 'you idiotic guy american in a hurry ']);



    }
}
