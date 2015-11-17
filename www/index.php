<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App\Slim(require(__DIR__ . '/../config.php'));

$app->run();
