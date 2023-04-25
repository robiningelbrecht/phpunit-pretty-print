<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use NunoMaduro\Collision\Adapters\Phpunit\Subscribers\EnsurePrinterIsRegisteredSubscriber;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration as PHPUnitConfiguration;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationFinishedSubscriber;

final class PhpUnitExtension implements Extension
{
    public function bootstrap(PHPUnitConfiguration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $configuration = Configuration::fromParameterCollection($parameters);

        $facade->replaceOutput();
        $facade->replaceProgressOutput();
        $facade->replaceResultOutput();

        $_SERVER['COLLISION_PRINTER'] = true;
        if ($configuration->useCompactMode()) {
            $_SERVER['COLLISION_PRINTER_COMPACT'] = true;
        }
        if ($configuration->displayProfiling()) {
            $_SERVER['COLLISION_PRINTER_PROFILE'] = true;
        }

        EnsurePrinterIsRegisteredSubscriber::register();
        $facade->registerSubscriber(new ApplicationFinishedSubscriber($configuration));
    }
}
