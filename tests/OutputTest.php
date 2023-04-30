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
        ];

        exec(implode(' ', $command), $out);
        $this->assertStringContainsString('Tests:    3 failed, 1 risky, 1 incomplete, 1 skipped, 3 passed (7 assertions)', implode(PHP_EOL, $out));
    }

    public function testWithProfiling(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-profiling.xml',
        ];

        exec(implode(' ', $command), $out);
        $output = implode(PHP_EOL, $out);
        $this->assertStringContainsString('Tests:    2 passed (4 assertions)', $output);
        $this->assertStringContainsString('Top 10 slowest tests', $output);
    }

    public function testWithProfilingAtRunTime(): void
    {
        $command = [
            'vendor/bin/phpunit',
            'tests/ExampleTests/TestThatPassesTest.php',
            '--configuration=tests/phpunit.test.xml',
            '-d --profiling',
        ];
        exec(implode(' ', $command), $out);
        $output = implode(PHP_EOL, $out);
        $this->assertStringContainsString('Tests:    2 passed (4 assertions)', $output);
        $this->assertStringContainsString('Top 10 slowest tests', $output);
    }

    public function testPrintCompactMode(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-compact-mode.xml',
        ];

        exec(implode(' ', $command), $out);
        $output = implode(PHP_EOL, $out);
        $this->assertStringContainsString('.⨯⨯⨯!si..', $output);
        $this->assertStringContainsString('Tests:    3 failed, 1 risky, 1 incomplete, 1 skipped, 3 passed (7 assertions)', $output);
    }

    public function testPrintCompactModeAtRunTime(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test.xml',
            '-d --compact',
        ];
        exec(implode(' ', $command), $out);
        $output = implode(PHP_EOL, $out);
        $this->assertStringContainsString('.⨯⨯⨯!si..', $output);
        $this->assertStringContainsString('Tests:    3 failed, 1 risky, 1 incomplete, 1 skipped, 3 passed (7 assertions)', $output);
    }

    public function testPrintWithQuote(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-with-quotes.xml',
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
}
