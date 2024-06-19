const subscribeButton = document.getElementById('subscribe')
const unsubscribeButton = document.getElementById('unsubscribe')
const errorArea = document.getElementById('errorArea')

// サービスワーカーを登録
if ('serviceWorker' in navigator && 'PushManager' in window) {
  navigator.serviceWorker.register('service-worker.js')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg)

      subscribeButton.addEventListener('click', function() {
        subscribe(swReg)
      })

      unsubscribeButton.addEventListener('click', function() {
        unsubscribe(swReg)
      })
    })
    .catch(function(error) {
      console.error('Service Worker Error', error)
    })
} else {
  console.warn('Push messaging is not supported')
  subscribeButton.setAttribute('disabled', 'true')
  unsubscribeButton.setAttribute('disabled', 'true')
  errorArea.innerText = 'プッシュ通知がサポートされていないブラウザです。iOS の場合は「ホーム画面に追加」を行い PWA 化した状態でご利用ください。'
}

function subscribe(swReg) {
  // 現在の通知設定の確認
  if ('Notification' in window) {
    let permission = Notification.permission
    console.log('notification permission: ' + permission)

    if (permission === 'denied') {
      alert('Push通知が拒否されているようです。ブラウザの設定からPush通知を有効化してください')
      return false
    } else if (permission === 'granted') {
      // granted になったとしても js 側でこれを解除することは出来ない。ブラウザの設定をいじらなければ解除できないので、ここで中断させてしまうと抜け出せなくなる恐れがある
      // alert('すでにWebPushを許可済みです')
      // return false
    }
  }

  swReg.pushManager.getSubscription()
    .then(function(subscription) {
      if (subscription) {
        alert('すでに購読されています。')
        console.log('すでに購読されています:', subscription);
      } else {
        const applicationServerKey = urlB64ToUint8Array(window.publicKey)
        swReg.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey
        })
        .then(function(subscription) {
          console.log('購読成功:', subscription)
          alert('本来はここでサーバに結果を送信して DB に保存するが、簡略化するために画面に結果を表示する')

          // 必要なトークンを変換して取得
          const key = subscription.getKey('p256dh')
          const token = subscription.getKey('auth')

          document.querySelector('#userEndpoint > span').innerText = subscription.endpoint
          document.querySelector('#userPublicKey > span').innerText = btoa(String.fromCharCode.apply(null, new Uint8Array(key)))
          document.querySelector('#userAuthToken > span').innerText = btoa(String.fromCharCode.apply(null, new Uint8Array(token)))
        })
        .catch(function(err) {
          alert('Push通知機能が拒否されたか、エラーが発生しましたので、Push通知設定が出来ませんでした。')
          console.log('購読失敗: ', err)
        })
      }
    })
}

function unsubscribe(swReg) {
  swReg.pushManager.getSubscription()
    .then(function(subscription) {
      if (subscription) {
        subscription.unsubscribe()
          .then(function() {
            console.log('User is unsubscribed.')
            alert('本来はここでサーバに結果を送信して DB に保存するが、簡略化している')
            alert('解除成功')
          })
          .catch(function(error) {
            alert('エラーが発生しましたので、Push通知設定を解除出来ませんでした。')
            console.log('Error unsubscribing', error)
          })
      } else {
        alert('購読していないため解除は不要です。')
      }
    })
    .catch(function(error) {
      alert('エラーが発生しましたので、Push通知設定を解除出来ませんでした。')
      console.log('Error unsubscribing', error)
    })
}

// VAPID公開キーをUint8Arrayに変換するヘルパー関数
function urlB64ToUint8Array (base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4)
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/')

  const rawData = window.atob(base64)
  const outputArray = new Uint8Array(rawData.length)

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i)
  }
  return outputArray
}
