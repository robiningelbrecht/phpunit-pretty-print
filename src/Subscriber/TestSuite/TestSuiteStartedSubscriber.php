<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestSuite;

use PHPUnit\Event\TestSuite\Started;
use PHPUnit\Event\TestSuite\StartedSubscriber;

use function Termwind\render;

final class TestSuiteStartedSubscriber implements StartedSubscriber
{
    public function notify(Started $event): void
    {
        if (!$event->testSuite()->isForTestClass()) {
            return;
        }
        render(sprintf(
            '<div><span class="text-neutral-100"><span class="font-bold">%s</span>, %s tests</span></div>',
            $event->testSuite()->name(),
            $event->testSuite()->count()
        ));
    }
}
