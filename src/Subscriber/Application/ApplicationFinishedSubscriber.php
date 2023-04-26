<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Quotes;

use function Termwind\render;

final class ApplicationFinishedSubscriber implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        render(sprintf('<div class="bg-green p-2">%s</div>', Quotes::getRandom()));
    }
}
