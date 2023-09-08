<?php

namespace Tests\Unit;

use PHPUnit\Event\Facade as EventFacade;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Builder;
use RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension;

class PhpUnitExtensionTest extends TestCase
{
    private array $originalServer = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalServer = $_SERVER;

        // We need to do some reflection magic here because of pour decisions in PHPUnit
        $eventFacade = EventFacade::instance();
        $reflection = new \ReflectionClass($eventFacade);
        $sealed = $reflection->getProperty('sealed');
        $sealed->setAccessible(true);
        $sealed->setValue($eventFacade, false);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $_SERVER = $this->originalServer;
    }

    public function testBootstrapWithAllOptions(): void
    {
        $facade = new Facade();

        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapInCompactMode(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'useCompactMode' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapWithDisplayProfiling(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testBootstrapWithDisplayQuote(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayQuote' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testItShouldBeEnabledThroughCli(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
            'enableByDefault' => 'false',
        ]);

        $extension = new PhpUnitExtension();

        $_SERVER['argv'][] = '--enable-pretty-print';

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testItShouldBeDisabledThroughCli(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $_SERVER['argv'][] = '--disable-pretty-print';

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertFalse($facade->replacesOutput());
        $this->assertFalse($facade->replacesProgressOutput());
        $this->assertFalse($facade->replacesResultOutput());

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testItShouldBeEnabledWithParameter(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
            'enableByDefault' => 'true',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertTrue($facade->replacesOutput());
        $this->assertTrue($facade->replacesProgressOutput());
        $this->assertTrue($facade->replacesResultOutput());

        $this->assertContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }

    public function testItShouldBeDisabledWithParameter(): void
    {
        $facade = new Facade();
        $configuration = (new Builder())->build([]);
        $parameters = ParameterCollection::fromArray([
            'displayProfiling' => 'true',
            'useCompactMode' => 'true',
            'displayQuote' => 'true',
            'enableByDefault' => 'false',
        ]);

        $extension = new PhpUnitExtension();

        $extension->bootstrap(
            $configuration,
            $facade,
            $parameters
        );

        $this->assertFalse($facade->replacesOutput());
        $this->assertFalse($facade->replacesProgressOutput());
        $this->assertFalse($facade->replacesResultOutput());

        $this->assertNotContains('COLLISION_PRINTER_COMPACT', array_keys($_SERVER));
        $this->assertNotContains('COLLISION_PRINTER_PROFILE', array_keys($_SERVER));
    }
}
