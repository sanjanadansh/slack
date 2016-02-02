<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respondToSlack($message, $original_message, $type = 'in_channel')
    {
        if(is_string($message))
            $message = trim($message);

        return ['response_type' => $type, 'text' => $message, 'attachments' => ['text' => $original_message]];
    }
}
