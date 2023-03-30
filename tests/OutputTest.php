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

    public function testPrintWithMethodNameConversion(): void
    {
        $command = [
            'vendor/bin/phpunit',
            '--configuration=tests/phpunit.test-with-method-name-conversion.xml',
            '--no-output',
        ];

        exec(implode(' ', $command), $out);
        $this->assertMatchesSnapshot(implode(PHP_EOL, $out), new SnapshotTextDriver());
    }

    public function testPrintWithQuotes(): void
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
            if (!str_contains($print, strtr($quote, ['%NAME%' => 'Robin']))) {
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
            '--configuration=tests/phpunit.test-with-method-name-conversion.xml',
        ];

        exec(implode(' ', $command), $out);
        $this->assertStringContainsString('Add the --no-output CLI option to make sure the output is flawless', implode(PHP_EOL, $out));
    }
}
