<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for st android';
$target_user_endpoint = 'https://fcm.googleapis.com/fcm/send/cm1xj4mld9o:APA91bEyKtZCMLJUkLNLxxhHkWrnFnWMUsl1YoBlMAVcG90wZd18ia5SqIpmCqS5tRpb1aXSzvLElHSEscPMpxHrT_Z1ZUYh4lowCHMSOhV5D8TsNML3-vjOtfVilpXuOHfVL5cIntE9';
$target_user_public_key = 'BCiL7Qc5KmH5dmbChAd9T9vyVljcdWoQJMv6Nohj/C6nsCPCThA8ZM2gQnu1dJvLeqCg4ULn6Xyvoo1y+d2m6i4=';
$target_user_auth_token = 'Nz/RxE2gHeCva+6ail4veQ==';

require_once(__DIR__.'/send.php');
