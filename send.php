<?php

declare(strict_types=1);

require_once(__DIR__.'/bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['title']) || !isset($_POST['body']) || !isset($_POST['url'])){
        exit('プッシュ通知に関する情報が入力されていません');
    }

    if(!isset($_POST['user_endpoint']) || !isset($_POST['user_public_key']) || !isset($_POST['user_auth_token'])){
        exit('送信先に関する情報が入力されていません');
    }

    $title = $_POST['title'];
    $body = $_POST['body'];
    $url = $_POST['url'];
    $user_endpoint = $_POST['user_endpoint'];
    $user_public_key = $_POST['user_public_key'];
    $user_auth_token = $_POST['user_auth_token'];

    $vapid_subject = ($_SERVER['HTTPS'] ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'];
    $public_key = $_ENV['PUBLIC_KEY'];
    $private_key = $_ENV['PRIVATE_KEY'];

    // push通知認証用のデータ
    $subscription = Subscription::create([
        'endpoint' => $user_endpoint,
        'publicKey' =>$user_public_key,
        'authToken' =>$user_auth_token,
    ]);

    // ブラウザに認証させる
    $auth = [
        'VAPID' => [
            'subject' => $vapid_subject,
            'publicKey' => $public_key,
            'privateKey' => $private_key,
        ]
    ];

    $webPush = new WebPush($auth);
    $body_array = [
        'title' => $title,
        'body' => $body,
        'tag' => $url
    ];
    $body_msg = base64_encode(json_encode($body_array, JSON_UNESCAPED_UNICODE));
    $report = $webPush->sendOneNotification($subscription, $body_msg);
    $endpoint = $report->getRequest()->getUri()->__toString();
    if ($report->isSuccess()) {
        echo '送信成功しました';
    } else {
        echo '送信失敗です';
    }
    echo "<br>";

    var_dump($report);

    echo "<br><br><br><br><br>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>WebPushテスト</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width,initial-scale=1'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <div class="container-sm p-4">
    <h3>プッシュ通知テスト</h3>

    <form class="border border-1 rounded p-4" action="/send.php" method="POST">
      <div class="my-3">
        <label class="form-label">title</label>
        <input type="text" class="form-control" name="title" value="これはサンプル通知です">
      </div>
      <div class="my-3">
        <label class="form-label">body</label>
        <input type="text" class="form-control" name="body" value="これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。">
      </div>
      <div class="my-3">
        <label class="form-label">url</label>
        <input type="text" class="form-control" name="url" value="https://www.yahoo.co.jp/">
      </div>
      <div class="my-3">
        <label class="form-label">user_endpoint</label>
        <!-- sm <input type="text" class="form-control" name="user_endpoint" value="https://fcm.googleapis.com/fcm/send/cMzg6M7qL-s:APA91bEZIE1zTdxx6Dawkv1RJoUb3t5xjvxKdMM7Q-GVQiHj3be94e8B_UgnNCbXU7nGv5TzZzdVl9SlgK_hz6GSlL323JLsVUtYpiQqrN0cUNvdfZOiIJcToFLjJWMgBHFqfeRGc0p3"> -->
        st <input type="text" class="form-control" name="user_endpoint" value="https://web.push.apple.com/QD7f6Orv1SwUJLkhUHsI-bgbiil1B9afQDWnK72o4oduKINSPdsVIpEKIa3xXenktr2wsZbzfyayQTt5Yv9OzR0fyyyInFaMs5MaqvK8FjKjLmOd8mp9xtSRlMYhlctf7shB4S6uT1AN6UC7hFs6LdIjLyEI9kjYN8VqIxQBZlY">
      </div>
      <div class="my-3">
        <label class="form-label">user_public_key</label>
        <!-- sm <input type="text" class="form-control" name="user_public_key" value="BKESu9PuHE9DZI6Rtpl0kwgA/hIfeAIQUQcS5GTb/OwFOs87Jo2pGGrhw5N5vqL1fud15VIuqb8p2fMRM1YLL5I="> -->
        st <input type="text" class="form-control" name="user_public_key" value="BKf34Hu6/ImWtrYXrK04WgWmcY5t6spUGAzkCjlcdw2FGqalYuI4zJJYfMq9qKTH6L0fZ5NQ8A7g3n2uT1MD+TQ=">
      </div>
      <div class="my-3">
        <label class="form-label">user_auth_token</label>
        <!-- sm <input type="text" class="form-control" name="user_auth_token" value="WHhQcJ3E7T6st3xkzDsNFA=="> -->
        st <input type="text" class="form-control" name="user_auth_token" value="Y7W3ZRVwWbITLVNAfpRTww==">
      </div>
      <div class="button-footer">
        <button class="btn btn-primary" type="submit">送信</button>
      </div>
    </form>
  </div>
</body>
</html>
