<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestRunner;

use PHPUnit\Event\TestRunner\Configured;
use PHPUnit\Event\TestRunner\ConfiguredSubscriber;

use function Termwind\render;

final class TestRunnerConfiguredSubscriber implements ConfiguredSubscriber
{
    public function notify(Configured $event): void
    {
        render(sprintf(
            '<div>Configuration: %s</div>',
            $event->configuration()->configurationFile()
        ));
        render('<div></div>');
    }
}
