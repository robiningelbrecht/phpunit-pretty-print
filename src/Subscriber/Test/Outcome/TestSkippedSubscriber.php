<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Test\Skipped;
use PHPUnit\Event\Test\SkippedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;

final class TestSkippedSubscriber extends TestOutcomeSubscriber implements SkippedSubscriber
{
    public function notify(Skipped $event): void
    {
        $this->write(
            Icon::WARNING,
            $event->test()->name(),
            $event->telemetryInfo()->durationSincePrevious()->asFloat(),
        );
    }
}
