function base64Decode(text,charset){
  return fetch(`data:text/plain;charset=${charset};base64,`+text).then(response=>response.text());
}
// プッシュ通知を受け取ったときのイベント
self.addEventListener('push', async function (event) {
  //serverからのメッセージ
  var msg=event.data.text();
  msg=await base64Decode(msg);
  msg=JSON.parse(msg);//JSONから配列データに変換
  const title = msg.title;
  const options = {
    body: msg.body, // メッセージ
    tag: msg.tag, // 通知固有のタグ(このプログラムではURLの伝達に使用)
    icon: 'icon.png', // アイコン
    badge: 'icon.png' // アイコン(縮小版)
  };
  event.waitUntil(self.registration.showNotification(title, options));
});

// プッシュ通知のクリックイベント
self.addEventListener('notificationclick', function (event) {
  var notification_url=event.notification.tag;//通知に関連付けられているURL
  event.notification.close();

  event.waitUntil(
    // プッシュ通知をクリックしたときに開くURL
    clients.openWindow(notification_url)
  );
});

// サービスワーカーをブラウザにインストール時
self.addEventListener('install', (event) => {
  console.log('service worker install ...');
});