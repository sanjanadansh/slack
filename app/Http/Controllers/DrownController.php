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
            $site     = $request->input('text');

            $site     = $this->seeIfEphemeral($site);

            $test_outputs = [];

            $command = sprintf("python /opt/public_drown_scanner/scanner.py %s 443", $site);

            exec($command, $test_outputs, $results);

            Log::info("Drown Results", $test_outputs);

            $output = implode(", ", $test_outputs);

            $message    = sprintf("The Results of your scan %s", $output);

            return Response::json($this->respondToSlack($message, $message, $this->getMessageType()));
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
