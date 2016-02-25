<?php

namespace App\Http\Controllers;

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
     * @var \App\JiraPayload
     */
    private $jiraPayload;
    /**
     * @var \App\SendSlackNotice
     */
    private $sendToSlack;

    public function __construct(JiraPayload $jiraPayload, SendSlackNotice $sendToSlack)
    {
        $this->jiraPayload = $jiraPayload;
        $this->sendToSlack = $sendToSlack;
    }


    public function webhook(Request $request)
    {

        try
        {
            $payload = $request->input();

            File::put('/tmp/payload.json', $payload);

            Log::info("Message Incoming from AHA");

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
