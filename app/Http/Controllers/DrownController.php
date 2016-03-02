<?php

namespace App\Http\Controllers;

use App\SlackTrait;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class DrownController extends Controller
{
    use SlackTrait;


    public function search(Request $request)
    {
        try
        {
            $output   = [];

            $site     = $request->input('text');

            $site     = $this->seeIfEphemeral($site);

            $test_outputs = [];

            $command = sprintf("cd /opt/public_drown_scanner/ && python scanner.py %s 443", $site);

            exec($command, $test_outputs, $results);

            $output[] = implode("\n", $test_outputs);

            $command = "cd /opt/tlsfuzzer && PYTHONPATH=. python scripts/test-sslv2-force-export-cipher.py -h alfrednutile.info -p 443";

            exec($command, $test_outputs, $results);

            $output[] = implode("\n", $test_outputs);

            return Response::json($this->respondToSlack("Results Below", implode("\n", $output), $this->getMessageType()));
        }
        catch(\Exception $e)
        {
            return Response::json($this->respondToSlack("Error scanning", null, 'in_channel'), 400);
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
