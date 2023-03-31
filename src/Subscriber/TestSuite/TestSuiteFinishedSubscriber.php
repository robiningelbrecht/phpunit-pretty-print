<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestSuite;

use PHPUnit\Event\TestSuite\Finished;
use PHPUnit\Event\TestSuite\FinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Configuration;
use RobinIngelbrecht\PHPUnitPrettyPrint\State;

use function Termwind\render;

final class TestSuiteFinishedSubscriber implements FinishedSubscriber
{
    public function __construct(
        private readonly Configuration $configuration
    ) {
    }

    public function notify(Finished $event): void
    {
        if (!$event->testSuite()->isForTestClass()) {
            return;
        }

        $testSuiteHasPassed = true;
        $unitTestOutcomes = State::getUnitTestOutcomes();
        foreach ($event->testSuite()->tests() as $test) {
            if ($unitTestOutcomes[$test->id()]->hasPassed()) {
                continue;
            }

            $testSuiteHasPassed = false;
        }

        render(sprintf(
            '<div class="flex justify-between">
                <span>
                    <span class="bg-%s px-1 mr-1 font-bold">%s</span>
                    <span class="font-bold text-neutral-100">%s</span>
                    <span class="text-neutral-100">, %s tests</span>
                </span>
                <span class="text-neutral-100 font-bold">%s%%</span>
            </div>',
            $testSuiteHasPassed ? 'green' : 'red',
            $testSuiteHasPassed ? 'PASS' : 'FAIL',
            $event->testSuite()->name(),
            $event->testSuite()->count(),
            round((State::getTestsWithOutcomeCount() / State::getTotalTestCount()) * 100)
        ));

        if ($this->configuration->useCompactMode()) {
            return;
        }

        foreach ($unitTestOutcomes as $unitTestOutcome) {
            $methodName = $unitTestOutcome->getTest()->name();

            render(sprintf(
                '<div class="ml-1"><span class="text-%s font-bold">  %s</span> <span class="text-neutral-400">%s [%ss]</span></div>',
                $unitTestOutcome->getIcon()->getColor(),
                $unitTestOutcome->getIcon()->value,
                $this->configuration->convertMethodNamesToSentences() ? $this->formatMethodName($methodName) : $methodName,
                round($unitTestOutcome->getDuration()->asFloat(), 4)
            ));
        }

        render('<div></div>');
    }

    private function formatMethodName(string $methodName): ?string
    {
        // Convert non-breaking method name to camelCase
        $methodName = str_replace(' ', '', ucwords($methodName, ' '));

        // Convert snakeCase method name to camelCase
        $methodName = str_replace('_', '', ucwords($methodName, '_'));

        preg_match_all('/((?:^|[A-Z])[a-z0-9]+)/', $methodName, $matches);

        // Prepend all numbers with a space
        $replaced = preg_replace('/(\d+)/', ' $1', $matches[0]);

        $testNameArray = array_map('strtolower', $replaced);

        $name = implode(' ', $testNameArray);

        // check if prefix is test remove it
        return preg_replace('/^test /', '', $name, 1);
    }
}
