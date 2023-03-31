<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\FailedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\Throwable;
use RobinIngelbrecht\PHPUnitPrettyPrint\UnitTestOutcome;

final class TestFailedSubscriber implements FailedSubscriber
{
    public function notify(Failed $event): void
    {
        State::incrementTotalTestsFailedCount();
        State::addThrowable(
            Throwable::createFromEvent($event)
        );
        State::addUnitTestOutcome(
            UnitTestOutcome::fromIconAndEvent(Icon::FAILED, $event)
        );
    }
}
