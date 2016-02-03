<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class JiraController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info($request->input());

        $content = $request->input();

        File::put(storage_path('fixtures/' . str_random() . '.json'), json_encode($content, 1));

    }
}
