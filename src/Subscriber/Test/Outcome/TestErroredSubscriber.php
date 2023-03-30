<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\ErroredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;

final class TestErroredSubscriber extends TestOutcomeSubscriber implements ErroredSubscriber
{
    public function notify(Errored $event): void
    {
        $this->write(
            Icon::FAILED,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
