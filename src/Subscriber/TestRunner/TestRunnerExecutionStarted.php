<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestRunner;

use PHPUnit\Event\TestRunner\ExecutionStarted;
use PHPUnit\Event\TestRunner\ExecutionStartedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

final class TestRunnerExecutionStarted implements ExecutionStartedSubscriber
{
    public function notify(ExecutionStarted $event): void
    {
        State::setTotalTestCount($event->testSuite()->count());
    }
}
