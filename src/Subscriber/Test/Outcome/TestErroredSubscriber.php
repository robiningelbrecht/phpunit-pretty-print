<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\ErroredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;
use RobinIngelbrecht\PHPUnitPrettyPrint\Throwable;
use RobinIngelbrecht\PHPUnitPrettyPrint\UnitTestOutcome;

final class TestErroredSubscriber implements ErroredSubscriber
{
    public function notify(Errored $event): void
    {
        State::incrementTotalTestsErroredCount();
        State::addThrowable(
            Throwable::createFromEvent($event)
        );

        State::addUnitTestOutcome(
            UnitTestOutcome::fromIconAndEvent(Icon::FAILED, $event)
        );
    }
}
