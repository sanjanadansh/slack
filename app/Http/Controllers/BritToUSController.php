<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Goutte\Client as GoutteClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class BritToUSController extends Controller
{

    protected $url = 'http://www.translatebritish.com/';

    /**
     * @var GoutteClient
     */
    protected $client;

    /**
     * @var Client
     */
    protected $guzzle;

    public function __construct(GoutteClient $client, Client $guzzle)
    {
        $this->client = $client;
        $this->guzzle = $guzzle;
    }

    public function usToBrit(Request $request)
    {
        try {

            Log::info($request->input());

            $crawler = $this->client->request('GET', $this->url . 'reverse.php');

            $form = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

            $crawler = $this->client->submit($form,
                array('p' => $request->input('text')));

            $results = $crawler->siblings()->filter('.translation-text')->text();

            return Response::json($this->respondToSlack($results, $request->input('text'), 'in_channel'));
        } catch (\Exception $e) {
            return Response::json($this->respondToSlack(sprintf("Error %s", $e->getMessage()), $request->input('text'), 'in_channel'), 400);
        }
    }

    public function britToUs(Request $request)
    {

        try {
            Log::info($request->input());

            $crawler = $this->client->request('GET', $this->url);

            $form = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

            $crawler = $this->client->submit($form,
                array('p' => $request->input('text')));

            $results = $crawler->siblings()->filter('.translation-text')->text();

            return Response::json($this->respondToSlack($results, $request->input('text'), 'in_channel'));
        } catch (\Exception $e) {
            return Response::json($this->respondToSlack(sprintf("Error %s", $e->getMessage()), $request->input('text'), 'in_channel'), 400);
        }

    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
