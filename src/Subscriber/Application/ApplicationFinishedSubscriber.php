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
        // Tests:    3 failed, 1 incomplete, 1 skipped, 81 passed (198 assertions)
        render(sprintf('<div class="text-neutral-400">Tests:%s
<span class="text-red font-bold">%s error(s)</span>, 
<span class="text-red font-bold">%s failed</span>, 
<span class="text-yellow font-bold">%s incomplete</span>, 
<span class="text-yellow font-bold">%s skipped</span>, 
<span class="text-green font-bold">%s passed</span> 
(%s tests, %s assertions)</div>',
            str_repeat('&nbsp;', 3),
            State::getTotalTestsErroredCount(),
            State::getTotalTestsFailedCount(),
            State::getTotalTestsMarkedIncompleteCount(),
            State::getTotalTestsSkippedCount(),
            State::getTotalTestsPassedCount(),
            State::getTotalTestCount(),
            State::getTotalAssertionCount()
        ));
        render(sprintf('
            <div><span class="text-neutral-400">Duration:</span> %ss</div>',
            round($event->telemetryInfo()->durationSinceStart()->asFloat(), 3)
        ));

        if (!$this->configuration->displayQuotesForName() || !$this->configuration->getNameToUseInQuotes()) {
            return;
        }

        render('<div></div>');
        render(sprintf('<div class="bg-green p-2">%s</div>', Quotes::getRandomWithName($this->configuration->getNameToUseInQuotes())));
    }
}
