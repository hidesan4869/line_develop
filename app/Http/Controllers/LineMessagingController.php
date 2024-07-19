<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Inertia\Inertia;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineMessagingController extends Controller
{
    public function index()
    {
        return Inertia::render('SendMessage');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|string',
        ]);

        $channelSecret = env('LINE_CHANNEL_SECRET');
        $channelAccessToken = env('LINE_CHANNEL_ACCESS_TOKEN');

        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken($channelAccessToken);

        $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
        );

        $message = [
            'type' => 'text',
            'text' => $request->input('message'),
            'sender' => [
                'name' => 'PIARYスタッフ みさき',
                'iconUrl' => 'https://line.me/conyprof'
            ]
        ];

        $pushMessageRequest = new PushMessageRequest([
            'to' => $request->input('user_id'),
            'messages' => [$message]
        ]);

        try {
            $messagingApi->pushMessage($pushMessageRequest);
            return back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }
}
