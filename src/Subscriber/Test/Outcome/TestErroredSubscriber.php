<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\ErroredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

final class TestErroredSubscriber extends TestOutcomeSubscriber implements ErroredSubscriber
{
    public function notify(Errored $event): void
    {
        State::incrementTotalTestsErroredCount();
        $this->write(
            Icon::FAILED,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
