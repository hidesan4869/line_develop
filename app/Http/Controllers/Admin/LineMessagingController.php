<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Inertia\Inertia;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\Admin\LineMessageService;


/**
 * LINEの返信画面
 */
class LineMessagingController extends AdminController
{
    protected $LineMessageService;
    public function __construct(LineMessageService $LineMessageService)
    {
        $this->LineMessageService = $LineMessageService;
    }

    public function index()
    {

        return Inertia::render('Admin/LineMessage');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|string',
        ]);

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
                'iconUrl' => 'https://thetv.jp/i/nw/245350/1549363.jpg?w=1284'
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
