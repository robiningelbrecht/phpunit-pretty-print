<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Event\Code\ComparisonFailure;
use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\Failed;

class Throwable
{
    private function __construct(
        private readonly Test $test,
        private readonly \PHPUnit\Event\Code\Throwable $throwable,
        private readonly ?ComparisonFailure $comparisonFailure
    ) {
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function getThrowable(): \PHPUnit\Event\Code\Throwable
    {
        return $this->throwable;
    }

    public function getClassName(): string
    {
        return $this->throwable->className();
    }

    public function getMessage(): string
    {
        return $this->throwable->message();
    }

    public function getComparisonFailure(): ?string
    {
        return $this->comparisonFailure?->diff();
    }

    public function getStackTrace(): string
    {
        $stackTrace = [];
        if ($trace = $this->getThrowable()->stackTrace()) {
            $stackTrace[] = $trace;
        }

        $currentThrowable = $this->getThrowable();
        while ($currentThrowable->hasPrevious()) {
            $stackTrace[] = 'Caused by'.PHP_EOL.$currentThrowable->previous()->stackTrace();
            $currentThrowable = $currentThrowable->previous();
        }

        return implode(PHP_EOL, $stackTrace);
    }

    public static function createFromEvent(Failed|Errored $event): self
    {
        return new self(
            $event->test(),
            $event->throwable(),
            $event instanceof Failed && $event->hasComparisonFailure() ? $event->comparisonFailure() : null,
        );
    }
}
