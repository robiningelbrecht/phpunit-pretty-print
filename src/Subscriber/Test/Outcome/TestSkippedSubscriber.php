<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Skipped;
use PHPUnit\Event\Test\SkippedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\UnitTestOutcome;

final class TestSkippedSubscriber implements SkippedSubscriber
{
    public function notify(Skipped $event): void
    {
        State::incrementTotalTestsSkippedCount();
        State::addUnitTestOutcome(
            UnitTestOutcome::fromIconAndEvent(Icon::WARNING, $event)
        );
    }
}
