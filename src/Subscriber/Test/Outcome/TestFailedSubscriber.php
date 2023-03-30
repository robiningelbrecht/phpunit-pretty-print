<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\FailedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;

final class TestFailedSubscriber extends TestOutcomeSubscriber implements FailedSubscriber
{
    public function notify(Failed $event): void
    {
        $this->write(
            Icon::FAILED,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
