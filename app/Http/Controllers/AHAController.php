<?php

namespace App\Http\Controllers;

use App\AHAPayload;
use App\JiraPayload;
use App\SendSlackNotice;
use App\SlackTrait;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AHAController extends Controller
{

    use SlackTrait;

    /**
     * @var \App\SendSlackNotice
     */
    private $sendToSlack;

    protected $slack_url = 'https://hooks.slack.com/services/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';

    /**
     * @var AHAPayload
     */
    private $AHAPayload;

    public function __construct(AHAPayload $AHAPayload, SendSlackNotice $sendToSlack)
    {
        $this->sendToSlack = $sendToSlack;
        $this->AHAPayload = $AHAPayload;
    }


    public function webhook(Request $request)
    {

        try
        {
            $payload = $request->input();

            //File::put('/tmp/payload.json', json_encode($payload, JSON_PRETTY_PRINT));
            Log::info("Message Incoming from AHA");
            Log::info($payload);
            
            $this->AHAPayload->setPayload($payload);

            $message = $this->AHAPayload->makeSlackMessage();

            $this->sendToSlack->setSlackUrl($this->slack_url)->sendMessageToSlack($message);


        }
        catch(\Exception $e)
        {
            Log::info(sprintf("Error sending message %s", $e->getMessage()));
        }
    }


    public function respondToSlack($message, $found, $type = 'in_channel')
    {
        return ['response_type' => $type, 'text' => $message, 'attachments' => [ ['text' =>  $found ] ] ];
    }
}
