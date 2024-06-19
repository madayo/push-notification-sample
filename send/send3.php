<?php

declare(strict_types=1);

require_once(__DIR__.'/../bootstrap.php');

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;


$target = 'for madayo pc';
$target_user_endpoint = 'https://fcm.googleapis.com/fcm/send/efVQxJZPrWQ:APA91bHIikjWFmgd-OhvJn-FuFMtlGxV386Cv6A87r7S261lfDkgUDb2yiqtUKJsxJVafLFa1yslTyiDcOkJCyYUsoCdbtcJbyHD65wSEdlx0L3zxHQZ34Ot9CPUwsqzljbV26aTBdil';
$target_user_public_key = 'BJaw4ed3KNdcxB+URVmUsYfZqK2mnFLwqepyJDiviNFTJNpoWAcUZDbgw66IZ7YbS+qvPMrR6b1wtzK9cnJwPzQ=';
$target_user_auth_token = '9kg0/phkk4wXcN45MBi1lA==';

require_once(__DIR__.'/send.php');
