<?php

namespace Tests\ExampleTests;

use PHPUnit\Framework\TestCase;

class TestThatPassesTest extends TestCase
{
    private const SLEEP_IN_MICRO_SECONDS = 10000;

    public function testDoBasicAssertions(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->assertFalse(false);
        $this->assertEquals(1, 1);
    }

    public function testDoSomeMoreAssertions(): void
    {
        usleep(self::SLEEP_IN_MICRO_SECONDS);
        $this->assertFalse(false);
        $this->assertEquals(1, 1);
    }
}
