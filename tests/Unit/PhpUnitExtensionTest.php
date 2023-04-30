<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Builder;
use RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationFinishedSubscriber;

class PhpUnitExtensionTest extends TestCase
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

    public function testBootstrapWithAllOptions(): void
    {
        $facade = $this->createMock(Facade::class);
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $facade
            ->expects($this->once())
            ->method('replaceOutput');

        $facade
            ->expects($this->once())
            ->method('replaceProgressOutput');

        $facade
            ->expects($this->once())
            ->method('replaceResultOutput');

        $facade
            ->expects($this->once())
            ->method('registerSubscriber')
            ->with(new ApplicationFinishedSubscriber());

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapInCompatMode(): void
    {
        $facade = $this->createMock(Facade::class);
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'useCompactMode' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $facade
            ->expects($this->once())
            ->method('replaceOutput');

        $facade
            ->expects($this->once())
            ->method('replaceProgressOutput');

        $facade
            ->expects($this->once())
            ->method('replaceResultOutput');

        $facade
            ->expects($this->never())
            ->method('registerSubscriber');

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapWithDisplayProfiling(): void
    {
        $facade = $this->createMock(Facade::class);
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $facade
            ->expects($this->once())
            ->method('replaceOutput');

        $facade
            ->expects($this->once())
            ->method('replaceProgressOutput');

        $facade
            ->expects($this->once())
            ->method('replaceResultOutput');

        $facade
            ->expects($this->never())
            ->method('registerSubscriber');

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapWithDisplayQuote(): void
    {
        $facade = $this->createMock(Facade::class);
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayQuote' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $facade
            ->expects($this->once())
            ->method('replaceOutput');

        $facade
            ->expects($this->once())
            ->method('replaceProgressOutput');

        $facade
            ->expects($this->once())
            ->method('replaceResultOutput');

        $facade
            ->expects($this->once())
            ->method('registerSubscriber')
            ->with(new ApplicationFinishedSubscriber());

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }
}
