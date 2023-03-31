<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Passed;
use PHPUnit\Event\Test\PassedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\UnitTestOutcome;

final class TestPassedSubscriber implements PassedSubscriber
{
    public function notify(Passed $event): void
    {
        State::incrementTotalTestsPassedCount();
        State::addUnitTestOutcome(
            UnitTestOutcome::fromIconAndEvent(Icon::PASSED, $event)
        );
    }
}
