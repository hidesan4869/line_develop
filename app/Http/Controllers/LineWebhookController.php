<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\SignatureValidator as SignatureValidator;

class LineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $channelSecret = env('LINE_CHANNEL_SECRET');
        $channelAccessToken = env('LINE_CHANNEL_ACCESS_TOKEN');

        Log::info('Webhook received', ['request' => $request->all()]);

        $signature = $request->header('X-Line-Signature');
        if (empty($signature) || !SignatureValidator::validateSignature($request->getContent(), $channelSecret, $signature)) {
            Log::warning('Invalid signature', ['signature' => $signature]);
            return response('Invalid signature', 400);
        }

        $httpClient = new CurlHTTPClient($channelAccessToken);
        $bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

        try {
            $events = $bot->parseEventRequest($request->getContent(), $signature);
            Log::info('Events parsed', ['events' => $events]);
        } catch (\Exception $e) {
            Log::error('Failed to parse events', ['error' => $e->getMessage()]);
            return response('Failed to parse events', 500);
        }

        foreach ($events as $event) {
            if ($event instanceof \LINE\LINEBot\Event\FollowEvent) {
                $userId = $event->getUserId();
                Log::info('Follow event received', ['userId' => $userId]);

                $response = $bot->getProfile($userId);
                if ($response->isSucceeded()) {
                    $profile = $response->getJSONDecodedBody();
                    $name = $profile['displayName'];
                    $email = ''; // LINEからはメールアドレスを取得できないので空にする

                    Log::info('User profile', ['profile' => $profile]);

                    try {
                        DB::table('dtb_user')->insert([
                            'name' => $name,
                            'email' => $email,
                            'password' => bcrypt(str_random(10)), // 一時的なパスワードを設定
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        Log::info('User inserted into database', ['name' => $name, 'email' => $email]);
                    } catch (\Exception $e) {
                        Log::error('Failed to insert user into database', ['error' => $e->getMessage()]);
                    }

                    $message = new TextMessageBuilder("こんにちは、$name さん！");
                    $bot->replyMessage($event->getReplyToken(), $message);
                } else {
                    Log::error('Failed to get profile', ['response' => $response->getRawBody()]);
                }
            }
        }

        return response('OK', 200);
    }
}
