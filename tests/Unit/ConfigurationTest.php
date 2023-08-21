<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Extension\ParameterCollection;
use RobinIngelbrecht\PHPUnitPrettyPrint\Configuration;

class ConfigurationTest extends TestCase
{
    private array $originalServer = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalServer = $_SERVER;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $_SERVER = $this->originalServer;
    }

    public function testFromParameterCollection(): void
    {
        $configuration = Configuration::fromParameterCollection(ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
        ]));

        $this->assertTrue($configuration->displayProfiling());
        $this->assertTrue($configuration->useCompactMode());
        $this->assertTrue($configuration->displayQuote());

        $configuration = Configuration::fromParameterCollection(ParameterCollection::fromArray([]));

        $this->assertFalse($configuration->displayProfiling());
        $this->assertFalse($configuration->useCompactMode());
        $this->assertFalse($configuration->displayQuote());
    }

    public function testFromParameterCollectionWithServerArguments(): void
    {
        $_SERVER['argv'][] = '--profiling';
        $_SERVER['argv'][] = '--compact';
        $_SERVER['argv'][] = '--display-quote';
        $configuration = Configuration::fromParameterCollection(ParameterCollection::fromArray([]));

        $this->assertTrue($configuration->displayProfiling());
        $this->assertTrue($configuration->useCompactMode());
        $this->assertTrue($configuration->displayQuote());
    }

    public function testIsFalsy(): void
    {
        $this->assertTrue(Configuration::isFalsy(0));
        $this->assertTrue(Configuration::isFalsy('false'));
        $this->assertTrue(Configuration::isFalsy(false));
        $this->assertTrue(Configuration::isFalsy('test'));

        $this->assertFalse(Configuration::isFalsy(1));
        $this->assertFalse(Configuration::isFalsy('true'));
        $this->assertFalse(Configuration::isFalsy(true));
    }
}
