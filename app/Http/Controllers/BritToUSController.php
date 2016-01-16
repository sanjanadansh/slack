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
        $this->validate($request, [ 'token' => 'required']);

        Log::info($request->input());

        $crawler = $this->client->request('GET', $this->url . 'reverse.php');

        $form    = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

        $crawler    = $this->client->submit($form,
            array('p' => $request->input('text')));

        $results = $crawler->siblings()->filter('.translation-text')->text();

        return Response::json(['text' => trim($results), ['attachments' => ['text' => $request->input('text')]]]);

    }

    public function britToUs(Request $request)
    {
        $this->validate($request, [ 'token' => 'required']);

        Log::info($request->input());

        $crawler = $this->client->request('GET', $this->url);

        $form    = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

        $crawler    = $this->client->submit($form,
            array('p' => $request->input('text')));

        $results = $crawler->siblings()->filter('.translation-text')->text();

        return Response::json(trim($results));

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
