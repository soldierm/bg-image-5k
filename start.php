<?php
declare(strict_types=1);

require 'vendor/autoload.php';

define('ROOT_PATH', __DIR__);

$spider = new \bg\Spider();
$spider->run();