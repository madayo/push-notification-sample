<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for st';
$target_user_endpoint = 'https://web.push.apple.com/QFOa9yA4wAihab3BAvBJRyQgKGvqPlS6GOl0BiJNR30MO-hSpyKIE-nyvOtp-EMfHYwCrZQP4069vrZAdq5ioudRdksx0IaTbBmoCqhiJuXHh-NEzOlZ83l0sXr7UwOWcPOG6GdbrXXv-S0L7ZcRky-0X8mwpmoBdwiRsfewiwo';
$target_user_public_key = 'BKYZgZZhjan9nWsM4s0ZFsg34Fnmlnz7796qTgc9bOVbCwuyHM0o05QSQ8zR7y1fN5v6xQmefPUUK1m/FK6DEh4=';
$target_user_auth_token = 'NTq7ENTCDPHKXzpz3t+mAg==';

require_once(__DIR__.'/send.php');
