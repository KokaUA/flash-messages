<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use PHPixie\Slice;
use PHPixie\HTTP;
use Koka\Flash\Flash;

$slice = new \PHPixie\Slice();
$http = new \PHPixie\HTTP($slice);
$container = $http->contextContainer($http->context($http->request()));

$flash = new Flash($container);

var_dump($flash->has());

$flash->info('Test info message');

var_dump($flash->has());

foreach ($flash as $msg) {
    echo "Type: {$msg->getType()} message: {$msg->getMessage()}";
}

var_dump($flash->has());
