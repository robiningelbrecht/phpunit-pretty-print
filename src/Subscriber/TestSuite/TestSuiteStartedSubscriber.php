<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestSuite;

use PHPUnit\Event\TestSuite\Started;
use PHPUnit\Event\TestSuite\StartedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

use function Termwind\render;

final class TestSuiteStartedSubscriber implements StartedSubscriber
{
    public function notify(Started $event): void
    {
        if (!$event->testSuite()->isForTestClass()) {
            return;
        }
        render(sprintf(
            '<div class="flex justify-between">
                <span class="text-neutral-100">
                    <span class="font-bold">%s</span>
                    <span>, %s tests</span>
                </span>
                <span class="text-neutral-100 font-bold">%s%%</span>
            </div>',
            $event->testSuite()->name(),
            $event->testSuite()->count(),
            round((State::getTestsWithOutcomeCount() / State::getTotalTestCount()) * 100)
        ));
    }
}
