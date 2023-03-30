<?php

namespace Tests\ExampleTests;

use PHPUnit\Framework\TestCase;

class TestThatPassesTest extends TestCase
{
    public function testDoBasicAssertions(): void
    {
        $this->assertFalse(false);
        $this->assertEquals(1, 1);
    }

    public function testDoSomeMoreAssertions(): void
    {
        $this->assertFalse(false);
        $this->assertEquals(1, 1);
    }
}
