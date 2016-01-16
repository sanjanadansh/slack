<?php

namespace App\Http\Controllers;

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

    public function __construct(GoutteClient $client)
    {
        $this->client = $client;
    }


    public function britToUs(Request $request)
    {
        $this->validate($request, [ 'source' => 'required']);

        Log::info($request->input());

        $crawler = $this->client->request('GET', $this->url);

        $form    = $crawler->siblings()->filterXPath('//*[@id="content-area"]/div/div[1]/div[1]/div[1]/div[1]/form')->form();

        $crawler    = $this->client->submit($form,
            array('p' => $request->input('source')));

        $results = $crawler->siblings()->filter('.translation-text')->text();


        return Response::json(['data' => $results], 200);

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
