<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application;

use PHPUnit\Event\Application\Started;
use PHPUnit\Event\Application\StartedSubscriber;

use function Termwind\render;

final class ApplicationStartedSubscriber implements StartedSubscriber
{
    public function notify(Started $event): void
    {
        render('<br />');
        render(sprintf(
            '<div>Runtime:%s%s</div>',
            str_repeat('&nbsp;', 7),
            $event->runtime()->asString()
        ));
    }
}
