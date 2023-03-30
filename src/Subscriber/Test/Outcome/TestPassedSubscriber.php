<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Passed;
use PHPUnit\Event\Test\PassedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

final class TestPassedSubscriber extends TestOutcomeSubscriber implements PassedSubscriber
{
    public function notify(Passed $event): void
    {
        State::incrementTotalTestPassedCount();
        $this->write(
            Icon::PASSED,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
