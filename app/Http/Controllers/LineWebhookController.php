<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $events = $request->events;

        foreach ($events as $event) {
            if (isset($event['source']['userId'])) {
                $userId = $event['source']['userId'];
                Log::info("User ID: $userId");
            }

            // ここにその他の処理を追加します
        }

        return response()->json(['status' => 'success'], 200);
    }
}

