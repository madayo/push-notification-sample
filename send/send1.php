<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for madayo';
$target_user_endpoint = 'https://fcm.googleapis.com/fcm/send/ezMJzF9Jlfg:APA91bGS0DfgsnbYRiXv_yw9YpBmDAP-zOyBan5Z6RGslom5SWk6_tDqQiibm28utmn79xnjyiTBu8T1V-Sfak9nNqnOZEfCSPUqWeKdLJzMk8dmSyLs3diLHPBgddhvFQLdR1EwpP-y';
$target_user_public_key = 'BPp6a6Lk880bDvCcXu/pAKsY0wnCcYT+ZLGjZdEvEeN8iFwkwoddAiXbFWYTGlNiBSwBN6d4omfchqcBVQkE970=';
$target_user_auth_token = 'kwoN2qfLzDsChoEHlwO8wQ==';

require_once(__DIR__.'/send.php');
