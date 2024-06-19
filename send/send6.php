<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for st ios google chrome';
$target_user_endpoint = 'https://web.push.apple.com/QPbEWiGLYxt2PnSmD3lRt3pmrLzXIo8TnAL06okGxIR9k0UYv3vNQRI0F1BvIV-WRQ2Iz3k5kYr9MwKu0wwl0B4ps5eL2PkRTUaA1z6V7EAxJUcb-lkmLPhi-1nQDkzQ_dmQb0ILRGXqiJ69PddnCani1SRs4yZQvt49dcgaCjs';
$target_user_public_key = 'BFtGx01vbxJWmBpNzcYkz5fQyiMbUzdT44pAKM8Df9DaXKCM2BhWwlGEOK0gXqLbM/M4eFMtEDPyVjl6s47s8pk=';
$target_user_auth_token = 'IVkHgSzp3uWXwcnPJVgOdg==';

require_once(__DIR__.'/send.php');
