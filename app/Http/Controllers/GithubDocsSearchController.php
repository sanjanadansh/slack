<?php

namespace App\Http\Controllers;

use App\SlackTrait;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class GithubDocsSearchController extends Controller
{
    use SlackTrait;


    public function search(Request $request)
    {
        try
        {
            $search     = $request->input('text');

            $search     = $this->seeIfEphemeral($search);

            $repo       = env('GITHUB_REPO');

            $results    = GitHub::search()->code(sprintf("%s repo:%s extension:md", $search, $repo));

            $found      = implode("\n", $this->transform($results));

            $message    = sprintf("Your original search %s total found %d", $search, $results['total_count']);

            Log::info(sprintf("%s", $message));


            return Response::json($this->respondToSlack($message, $found, $this->getMessageType()));
        }
        catch(\Exception $e)
        {
            return Response::json($this->respondToSlack("Error searching", null, 'in_channel'), 400);
        }

    }

    public function respondToSlack($message, $found, $type = 'in_channel')
    {
        return ['response_type' => $type, 'text' => $message, 'attachments' => [ ['text' =>  $found ] ] ];
    }

    protected function transform($results)
    {
        $output = [];

        foreach($results['items'] as $item)
        {
            $file_name  = $item['name'];
            $file_path  = $item['html_url'];
            $result     = sprintf("File: %s Path: %s", $file_name, $file_path);
            $output[] = $result;
        }

        return $output;
    }



}
