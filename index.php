<?php
require_once(__DIR__.'/bootstrap.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>WebPushテスト</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width,initial-scale=1'>

  <!-- ホーム画面に追加、ではなくインストールと表示させる。 android 用？ -->
  <meta name="mobile-web-app-capable" content="yes">
  <!-- アドレスバー等のブラウザのUIを非表示 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <!-- default（Safariと同じ） / black（黒） / black-translucent（ステータスバーをコンテンツに含める） -->
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <!-- ホーム画面に表示されるアプリ名 -->
  <meta name="apple-mobile-web-app-title" content="WebPush Test">
  <!-- ホーム画面に表示されるアプリアイコン -->
  <link rel="apple-touch-icon" href="icon.png">
  <!-- ウェブアプリマニフェスト -->
  <link rel="manifest" href="manifest.json">

  <script>
    // node を入れていないので dotenv は php 側でしか扱えない
    window.publicKey = "<?= $_ENV['PUBLIC_KEY'] ?>"
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <div class="container-sm p-4">
    <h3>プッシュ通知テスト</h3>
    <div class="my-4 d-flex justify-content-evenly">
      <button class="btn btn-primary" id="subscribe">購読</button>
      <button class="btn btn-danger" id="unsubscribe">解除</button>
    </div>

    <section id="errorArea"></section>
    <section>
      <span>ブラウザ情報</span>
      <div id="UAArea"></div>
    </section>

    <section class="my-4 d-flex flex-column">
      <h4>結果エリア</h4>
      <div id="userEndpoint" class="d-flex gap-3">
        <label>userEndpoint: </label>
        <span></span>
      </div>
      <div id="userPublicKey" class="d-flex gap-3">
        <label>userPublicKey: </label>
        <span></span>
      </div>
      <div id="userAuthToken" class="d-flex gap-3">
        <label>userAuthToken: </label>
        <span></span>
      </div>
    <section>
  </div>

  <script defer src='service-worker.js'></script>
  <script src='app.js'></script>
  <script>
    const userAgent = window.navigator.userAgent
    document.querySelector('#UAArea').innerText = userAgent
  </script>
</body>
</html>
