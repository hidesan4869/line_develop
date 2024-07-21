<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\SignatureValidator as SignatureValidator;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use GuzzleHttp\Client;

class LineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $channelSecret = env('LINE_CHANNEL_SECRET'); // LINEチャネルシークレット
        $channelAccessToken = env('LINE_CHANNEL_ACCESS_TOKEN'); // LINEチャネルアクセストークン

        // リクエストのシグネチャ検証
        $signature = $request->header('X-Line-Signature');
        if (empty($signature) || !SignatureValidator::validateSignature($request->getContent(), $channelSecret, $signature)) {
            return response('Invalid signature', 400);
        }

        // LINE SDKの設定
        $httpClient = new CurlHTTPClient($channelAccessToken);
        $bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

        // イベントをパース
        $events = $bot->parseEventRequest($request->getContent(), $signature);

        foreach ($events as $event) {
            if ($event instanceof \LINE\LINEBot\Event\FollowEvent) {
                // 友達登録イベント
                $userId = $event->getUserId();

                // ユーザープロフィールを取得
                $response = $bot->getProfile($userId);
                if ($response->isSucceeded()) {
                    $profile = $response->getJSONDecodedBody();
                    $name = $profile['displayName'];
                    $email = ''; // LINEからはメールアドレスを取得できないので空にする

                    // データベースに保存
                    DB::table('dtb_user')->insert([
                        'name' => $name,
                        'email' => $email,
                        'password' => bcrypt(str_random(10)), // 一時的なパスワードを設定
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // 返信メッセージを送信（任意）
                    $message = new TextMessageBuilder("こんにちは、$name さん！");
                    $bot->replyMessage($event->getReplyToken(), $message);
                }
            }
        }

        return response('OK', 200);
    }
}
