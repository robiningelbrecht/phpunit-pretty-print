<?php

namespace Tests\ExampleTests;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class TestThatHasAllStatusesTest extends TestCase
{
    use MatchesSnapshots;

    private const SLEEP_IN_MICRO_SECONDS = 10000;

    protected function setUp(): void
    {
        parent::setUp();

        usleep(self::SLEEP_IN_MICRO_SECONDS);
    }

    public function testSuccess(): void
    {
        $this->assertTrue(true);
    }

    public function testFail(): void
    {
        $this->assertTrue(false);
    }

    public function testFailWithDiff(): void
    {
        $this->assertEquals(
            ['one', 'two'],
            ['two', 'one']
        );
    }

    public function testError(): void
    {
        throw new \Exception('error');
    }

    public function testRisky(): void
    {
    }

    public function testSkip(): void
    {
        $this->markTestSkipped('skipped');
    }

    public function testIncomplete(): void
    {
        $this->markTestIncomplete('incomplete');
    }
}
