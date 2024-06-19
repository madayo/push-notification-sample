<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for na';
$target_user_endpoint = 'https://web.push.apple.com/QKHcHRTnkBA8sDsOyLyalgLwJB280uJe3UgmrAAGA8lPIQcR6ZzCrh5ScpXBnFNieLi0xxQip-X6mm3QdushIsNkVRKKiFKjRRSLH46hgy7veDTw-9Ecj52vJhvRj83rgqOxQHzb-ln32gFy7qeeC0qEW90pJ_lWKmVhdo8gL38';
$target_user_public_key = 'BE0jkx4MJbxYl7i4dfNb7bLyaAdk4saf/ITSnd9AL03t+KqHPLkT+RnLvKgTXQh5wjXZSpElyxYFGzpfOicvDOo=';
$target_user_auth_token = '+MFUMv502Na3lnFYa6qBWA==';

require_once(__DIR__.'/send.php');
