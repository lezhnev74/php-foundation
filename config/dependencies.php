<?php

use Interop\Container\ContainerInterface;

// A list of dependencies and factories to resolve them
return [
    \Psr\Log\LoggerInterface::class => function (ContainerInterface $container) {
        $log       = new \Monolog\Logger(app_deploy());
        $handler   = new \Monolog\Handler\RotatingFileHandler(storage_path('logs/app.log'), 10, \Monolog\Logger::DEBUG);
        $formatter = new \Monolog\Formatter\LineFormatter(null, null, true, true);
        $handler->setFormatter($formatter);

        $log->pushHandler($handler);
        return $log;
    },
];