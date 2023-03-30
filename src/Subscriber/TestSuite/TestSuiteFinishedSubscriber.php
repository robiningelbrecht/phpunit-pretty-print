<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestSuite;

use PHPUnit\Event\TestSuite\Finished;
use PHPUnit\Event\TestSuite\FinishedSubscriber;

use function Termwind\render;

final class TestSuiteFinishedSubscriber implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        if (!$event->testSuite()->isForTestClass()) {
            return;
        }

        render('<div></div>');
    }
}
