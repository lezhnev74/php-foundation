<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 13/02/2018
 */

include(__DIR__ . "/../helpers.php");
include(__DIR__ . "/../vendor/autoload.php");

////////////////////
// 1. CONFIGURATION
////////////////////
// 1.1. ENV loader - env variables automatically loaded and object is no more required
(new Dotenv\Dotenv(__DIR__ . "/../"))->overload();
// 1.2. Configuration loader available as a global config function (just for convenience)
function config(string $var, mixed $default = null)
{
    static $config = null;
    if (!$config) {
        $config = \Gestalt\Configuration::load(new \Gestalt\Loaders\PhpDirectoryLoader(base_path('config')));
    }

    return $config->get($var, $default);
}

////////////////////
// 2. CONTAINER
////////////////////
/// Container is also a global function
function container(): \Psr\Container\ContainerInterface
{
    static $container = null;
    if (!$container) {
        $builder = new \DI\ContainerBuilder();
        // Disable caching on production
        if (!config('app.debug')) {
            $builder->setDefinitionCache(new \Doctrine\Common\Cache\FilesystemCache(storage_path('cache')));
            $builder->writeProxiesToFile(true, storage_path('cache'));
        }
        $builder->addDefinitions(config('dependencies'));
        $container = $builder->build();
    }

    return $container;
}

////////////////////
// 3. Error handler
////////////////////
/// Error handler has different formatters for different input channels: console, html or json
$whoops = new \Whoops\Run;
if (Whoops\Util\Misc::isCommandLine()) {
    $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler());
} else {
    if (Whoops\Util\Misc::isAjaxRequest()) {
        $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
    } else {
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    }
}
// Whenever error is handled, we log it to the text file
$whoops->pushHandler(new \Whoops\Handler\CallbackHandler(function ($exception, $inspector, $run) {
    $logger = container()->get(\Psr\Log\LoggerInterface::class);
    $logger->critical($exception->getMessage(), ['exception' => $exception]);
}));
$whoops->register();

// Starting sequence is finished now...
