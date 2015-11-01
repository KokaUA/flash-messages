<?php
require_once(__DIR__.'/../vendor/autoload.php');

use PHPixie\Slice;
use PHPixie\HTTP;
use Koka\Flash\Messages;


$slice = new \PHPixie\Slice();
$http = new \PHPixie\HTTP($slice);
$container = $http->contextContainer($http->context($http->request()));

$messages = new Messages($container);

$messages->notice('test notice');

foreach ($messages as $msg) {
    echo "<div class='alert alert-{$msg->getType()}' role='alert'>{$msg}</div>";
}
