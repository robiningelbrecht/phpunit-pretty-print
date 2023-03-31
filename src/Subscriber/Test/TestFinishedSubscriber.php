<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

final class TestFinishedSubscriber implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        State::incrementTotalAssertionCountWith($event->numberOfAssertionsPerformed());
    }
}
