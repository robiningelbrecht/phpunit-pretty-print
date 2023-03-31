<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\ErroredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\Throwable;

final class TestErroredSubscriber extends TestOutcomeSubscriber implements ErroredSubscriber
{
    public function notify(Errored $event): void
    {
        State::incrementTotalTestsErroredCount();
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
