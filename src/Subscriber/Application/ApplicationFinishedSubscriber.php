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
        render(sprintf('<div>Tests:%s%s, <span class="text-green font-bold">%s passed</span>, <span class="text-red font-bold">%s failed</span> (%s assertions)</div>',
            str_repeat('&nbsp;', 4),
            State::getTotalTestCount(),
            State::getTotalTestPassedCount(),
            State::getTotalTestFailedCount(),
            State::getTotalAssertionCount()
        ));
        render(sprintf('<div>Duration: %ss</div>', round($event->telemetryInfo()->durationSinceStart()->asFloat(), 3)));

        if (!$this->configuration->displayQuotesForName() || !$this->configuration->getNameToUseInQuotes()) {
            return;
        }

        render('<div></div>');
        render(sprintf('<div class="bg-green p-2">%s</div>', Quotes::getRandomWithName($this->configuration->getNameToUseInQuotes())));
    }
}
