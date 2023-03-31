<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Telemetry\Duration;
use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\MarkedIncomplete;
use PHPUnit\Event\Test\Passed;
use PHPUnit\Event\Test\Skipped;

class UnitTestOutcome
{
    private function __construct(
        private readonly Icon $icon,
        private readonly Test $test,
        private readonly Duration $duration,
        private readonly bool $hasPassed,
    ) {
    }

    public function getIcon(): Icon
    {
        return $this->icon;
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function hasPassed(): bool
    {
        return $this->hasPassed;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public static function fromIconAndEvent(Icon $icon, Errored|Failed|Passed|Skipped|MarkedIncomplete $event): self
    {
        return new self(
            $icon,
            $event->test(),
            $event->telemetryInfo()->durationSincePrevious(),
            $event instanceof Passed
        );
    }
}
