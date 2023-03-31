<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\FailedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\Throwable;

final class TestFailedSubscriber extends TestOutcomeSubscriber implements FailedSubscriber
{
    public function notify(Failed $event): void
    {
        State::incrementTotalTestsFailedCount();
        State::addThrowable(
            Throwable::createFromEvent($event)
        );

        $this->write(
            Icon::FAILED,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
