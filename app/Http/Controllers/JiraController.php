<?php

namespace App\Http\Controllers;

use App\JiraPayload;
use App\SendSlackNotice;
use App\SlackTrait;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class JiraController extends Controller
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

            $this->jiraPayload->setPayload($payload);

            if(!$this->jiraPayload->userOnTeam($this->jiraPayload->getAssigneeEmail()))
                return false;

            $message = $this->jiraPayload->makeIssueUpdatedMessage();

            $this->sendToSlack->sendMessageToSlack($message);

            Log::info("Message Sent to Slack");
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
