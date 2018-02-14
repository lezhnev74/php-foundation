<?php

require __DIR__ . "/../bootstrap/start.php";

$log = container()->get(\Psr\Log\LoggerInterface::class);
$log->info("Message", ['some'=>1]);
echo "ok";
