<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\MarkedIncomplete;
use PHPUnit\Event\Test\MarkedIncompleteSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

final class TestMarkedInCompleteSubscriber extends TestOutcomeSubscriber implements MarkedIncompleteSubscriber
{
    public function notify(MarkedIncomplete $event): void
    {
        State::incrementTotalTestsMarkedIncompleteCount();
        $this->write(
            Icon::WARNING,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
