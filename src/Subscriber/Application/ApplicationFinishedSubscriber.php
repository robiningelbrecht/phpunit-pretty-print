<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Configuration;
use RobinIngelbrecht\PHPUnitPrettyPrint\Quotes;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

use function Termwind\render;

final class ApplicationFinishedSubscriber implements FinishedSubscriber
{
    public function __construct(
        private readonly Configuration $configuration
    ) {
    }

    public function notify(Finished $event): void
    {
        $summary = [];
        if ($countErrored = State::getTotalTestsErroredCount()) {
            $summary[] = sprintf('<span class="text-red font-bold">%s error(s)</span>', $countErrored);
        }
        if ($countFailed = State::getTotalTestsFailedCount()) {
            $summary[] = sprintf('<span class="text-red font-bold">%s failed</span>', $countFailed);
        }
        if ($countIncomplete = State::getTotalTestsMarkedIncompleteCount()) {
            $summary[] = sprintf('<span class="text-yellow font-bold">%s incomplete</span>', $countIncomplete);
        }
        if ($countSkipped = State::getTotalTestsSkippedCount()) {
            $summary[] = sprintf('<span class="text-yellow font-bold">%s skipped</span>', $countSkipped);
        }
        if ($countPassed = State::getTotalTestsPassedCount()) {
            $summary[] = sprintf('<span class="text-green font-bold">%s passed</span>', $countPassed);
        }

        render(sprintf('
            <div class="text-neutral-400">Tests:%s%s (%s tests, %s assertions)</div>',
            str_repeat('&nbsp;', 4),
            implode(', ', $summary),
            State::getTotalTestCount(),
            State::getTotalAssertionCount()
        ));
        render(sprintf('
            <div><span class="text-neutral-400">Duration:</span> %ss</div>',
            round($event->telemetryInfo()->durationSinceStart()->asFloat(), 3)
        ));

        if (!$this->configuration->displayQuote()) {
            return;
        }

        render('<div></div>');
        render(sprintf('<div class="bg-green p-2">%s</div>', Quotes::getRandom()));
    }
}
