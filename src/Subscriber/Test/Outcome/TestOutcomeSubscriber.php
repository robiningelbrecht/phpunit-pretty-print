<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome;

use PHPUnit\Event\Subscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Configuration;
use RobinIngelbrecht\PHPUnitPrettyPrint\Icon;

use function Termwind\render;

abstract class TestOutcomeSubscriber implements Subscriber
{
    public function __construct(
        private readonly Configuration $configuration
    ) {
    }

    protected function write(
        Icon $icon,
        string $methodName,
        float $duration): void
    {
        render(sprintf(
            '<div><span class="text-%s font-bold">  %s</span> <span class="text-neutral-400">%s [%ss]</span></div>',
            $icon->getColor(),
            $icon->value,
            $this->configuration->convertMethodNamesToSentences() ? $this->formatMethodName($methodName) : $methodName,
            round($duration, 4)
        ));
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
