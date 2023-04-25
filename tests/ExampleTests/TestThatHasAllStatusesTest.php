<?php

namespace Tests\ExampleTests;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class TestThatHasAllStatusesTest extends TestCase
{
    use MatchesSnapshots;

    private const SLEEP_IN_MICRO_SECONDS = 10000;

    public function testSuccess(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->assertTrue(true);
    }

    public function testFail(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->assertTrue(false);
    }

    public function testFailWithDiff(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->assertEquals(
            ['one', 'two'],
            ['two', 'one']
        );
    }

    public function testError(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        throw new \Exception('error');
    }

    public function testRisky(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
    }

    public function testSkip(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->markTestSkipped('skipped');
    }

    public function testIncomplete(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->markTestIncomplete('incomplete');
    }
}
