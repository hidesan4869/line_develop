<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // リクエスト全体をログに出力（JSON形式）
        Log::info('Received request: ' . json_encode($request->all(), JSON_PRETTY_PRINT));

        $events = $request->get('events');
        Log::info('Received events: ' . json_encode($events, JSON_PRETTY_PRINT));

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

