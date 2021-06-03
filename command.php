<?php

require __DIR__ . '/vendor/autoload.php';

$params = getopt('', [
    "path:",
    "silence-chapter-duration:",
    "max-segment-duration:",
    "silence-segment-duration:",
]);

$app = new App\App(__DIR__);
$app->run($params);


