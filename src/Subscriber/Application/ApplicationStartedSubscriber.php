<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application;

use PHPUnit\Event\Application\Started;
use PHPUnit\Event\Application\StartedSubscriber;

use function Termwind\render;

class ApplicationStartedSubscriber implements StartedSubscriber
{
    public function notify(Started $event): void
    {
        render('<br />');
        render(sprintf(
            '<div>&nbsp;&nbsp;Runtime: %s</div>',
            $event->runtime()->asString()
        ));
        if (isset($_SERVER['PHPUNIT_RANDOM_ORDER_SEED']) && !is_null($_SERVER['PHPUNIT_RANDOM_ORDER_SEED'])) {
            render(sprintf(
                '<div>&nbsp;&nbsp;Random Seed: %s</div>',
                $_SERVER['PHPUNIT_RANDOM_ORDER_SEED']
            ));
        }
    }
}
