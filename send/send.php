<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

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
        'publicKey' => $user_public_key,
        'authToken' => $user_auth_token,
    ]);

    // ブラウザに認証させる
    $webPush = new WebPush([
        'VAPID' => [
            'subject' => $vapid_subject,
            'publicKey' => $public_key,
            'privateKey' => $private_key,
        ]
    ]);
    $body_array = [
        'title' => $title,
        'body' => $body,
        'url' => $url,
        'id' => uniqid(), // 疑似的なユニークID。これにより通知がグルーピングされることを防いで毎回通知させる
    ];
    $body_msg = base64_encode(json_encode($body_array, JSON_UNESCAPED_UNICODE));
    $report = $webPush->sendOneNotification($subscription, $body_msg);
    $endpoint = $report->getRequest()->getUri()->__toString();

    var_dump($report);
    $message = '';
    if ($report->isSuccess()) {
        $message .= '<p style="color: green;">送信成功しました</p>';
    } else {
        $message .= '<p style="color: red;">送信失敗です</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>WebPushテスト</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width,initial-scale=1'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <style>
  input:read-only {
    outline: none;
    border: none;
  }
  </style>
</head>

<body>
  <div class="container-sm p-4">
    <h3>プッシュ通知テスト</h3>
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <form class="border border-1 rounded p-4" action="" method="POST">
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

      <h3><?= $target ?></h3>
      <div class="my-3">
        <label class="form-label">user_endpoint</label>
        <input type="text" readonly class="form-control" name="user_endpoint" value="<?= $target_user_endpoint ?>">
      </div>
      <div class="my-3">
        <label class="form-label">user_public_key</label>
        <input type="text" readonly class="form-control" name="user_public_key" value="<?= $target_user_public_key ?>">
      </div>
      <div class="my-3">
        <label class="form-label">user_auth_token</label>
        <input type="text" readonly class="form-control" name="user_auth_token" value="<?= $target_user_auth_token ?>">
      </div>
      <div class="button-footer">
        <button class="btn btn-primary" type="submit">送信</button>
      </div>
    </form>
  </div>
</body>
</html>
