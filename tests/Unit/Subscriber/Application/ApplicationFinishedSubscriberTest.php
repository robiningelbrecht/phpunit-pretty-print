<?php

namespace Tests\Unit\Subscriber\Application;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Telemetry\Duration;
use PHPUnit\Event\Telemetry\GarbageCollectorStatus;
use PHPUnit\Event\Telemetry\HRTime;
use PHPUnit\Event\Telemetry\Info;
use PHPUnit\Event\Telemetry\MemoryUsage;
use PHPUnit\Event\Telemetry\Snapshot;
use PHPUnit\Framework\TestCase;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationFinishedSubscriber;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\SpyOutput;

use function Termwind\renderUsing;

class ApplicationFinishedSubscriberTest extends TestCase
{
    use MatchesSnapshots;

    public function testNotify(): void
    {
        $spyOutput = new SpyOutput();
        renderUsing($spyOutput);

        $subscriber = new ApplicationFinishedSubscriber();
        $subscriber->notify(new Finished(
            new Info(
                new Snapshot(
                    HRTime::fromSecondsAndNanoseconds(1, 0),
                    MemoryUsage::fromBytes(100),
                    MemoryUsage::fromBytes(100),
                    new GarbageCollectorStatus(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                ),
                Duration::fromSecondsAndNanoseconds(1, 0),
                MemoryUsage::fromBytes(100),
                Duration::fromSecondsAndNanoseconds(1, 0),
                MemoryUsage::fromBytes(100),
            ),
            0
        ));

        $this->assertEquals(3, substr_count($spyOutput, '<bg=green>'));
    }
}
