<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\MarkedIncomplete;
use PHPUnit\Event\Test\MarkedIncompleteSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\UnitTestOutcome;

final class TestMarkedInCompleteSubscriber implements MarkedIncompleteSubscriber
{
    public function notify(MarkedIncomplete $event): void
    {
        State::incrementTotalTestsMarkedIncompleteCount();
        State::addUnitTestOutcome(
            UnitTestOutcome::fromIconAndEvent(Icon::WARNING, $event)
        );
    }
}
