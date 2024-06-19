function base64Decode(text,charset){
  return fetch(`data:text/plain;charset=${charset};base64,`+text).then(response=>response.text());
}
// プッシュ通知を受け取ったときのイベント
self.addEventListener('push', function (event) {
  event.waitUntil(
    (async () => {
      // serverからのメッセージ
      var msg = event.data.text();
      msg = await base64Decode(msg);
      msg = JSON.parse(msg); // JSONから配列データに変換
      const title = msg.title;
      const options = {
        body: msg.body, // メッセージ
        tag: msg.id, // ID。重複している場合は正常に通知されないおそれあり。グルーピングされる
        data: { url: msg.url }, // URLをdataプロパティに格納。別途、通知タップ時の処理は定義すること
        icon: 'icon.png', // アイコン
        badge: 'icon.png' // アイコン(縮小版)
      };
      return self.registration.showNotification(title, options);
    })()
  );
});


// プッシュ通知のクリックイベント
self.addEventListener('notificationclick', function (event) {
  console.log('Notification click Received.', event.notification.data);

  if (event.notification.data && event.notification.data.url) {
    const notification_url = event.notification.data.url;
    event.notification.close(); // 通知を閉じる

    event.waitUntil(
      clients.openWindow(notification_url) // 通知のURLを開く
    );
  } else {
    console.log('No URL provided with notification');
  }
});
