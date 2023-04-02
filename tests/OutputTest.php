<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\PHPUnitPrettyPrint\Quotes;
use Spatie\Snapshots\MatchesSnapshots;

class OutputTest extends TestCase
{
    use MatchesSnapshots;

    public function testPrintWithoutConfig(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test.xml',
            '--no-output',
        ];

        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrettifyMethodNames(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-prettify-method-names.xml',
            '--no-output',
        ];

        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrettifyMethodNamesAtRunTime(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test.xml',
            '--no-output',
            '-d --prettify-method-names',
        ];
        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrintCompactMode(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-compact-mode.xml',
            '--no-output',
        ];

        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrintCompactModeAtRunTime(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test.xml',
            '--no-output',
            '-d --compact',
        ];
        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrintWithQuote(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-with-quotes.xml',
            '--no-output',
        ];

        exec(implode(' ', $command), $out);

        $print = implode(PHP_EOL, $out);

        $printContainsQuote = false;
        foreach (Quotes::getAll() as $quote) {
            if (!str_contains($print, $quote)) {
                continue;
            }

            $printContainsQuote = true;
            $this->addToAssertionCount(1);
        }

        if (!$printContainsQuote) {
            $this->fail('Quote not found');
        }
    }

    public function testPrintWithQuoteAtRuntime(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test.xml',
            '--no-output',
            '-d --display-quote',
        ];

        exec(implode(' ', $command), $out);

        $print = implode(PHP_EOL, $out);

        $printContainsQuote = false;
        foreach (Quotes::getAll() as $quote) {
            if (!str_contains($print, $quote)) {
                continue;
            }

            $printContainsQuote = true;
            $this->addToAssertionCount(1);
        }

        if (!$printContainsQuote) {
            $this->fail('Quote not found');
        }
    }

    public function testPrintWhenNoOutputArgumentIsProvided(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-prettify-method-names.xml',
        ];

        exec(implode(' ', $command), $out);
        $this->assertStringContainsString('Add the --no-output CLI option to make sure the output is flawless', implode(PHP_EOL, $out));
    }
}
