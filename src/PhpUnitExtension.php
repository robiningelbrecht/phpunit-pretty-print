<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration as PHPUnitConfiguration;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationFinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationStartedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome\TestErroredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome\TestFailedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome\TestMarkedInCompleteSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome\TestPassedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\Outcome\TestSkippedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Test\TestFinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestRunner\TestRunnerConfiguredSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestRunner\TestRunnerExecutionStarted;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\TestSuite\TestSuiteFinishedSubscriber;

final class PhpUnitExtension implements Extension
{
    public function bootstrap(PHPUnitConfiguration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $configuration = Configuration::fromParameterCollection($parameters);

        $facade->replaceOutput();
        $facade->replaceProgressOutput();
        $facade->replaceResultOutput();
        $facade->registerSubscribers(
            // APPLICATION SUBSCRIBERS.
            new ApplicationStartedSubscriber(),
            new ApplicationFinishedSubscriber($configuration),
            // TEST RUNNER SUBSCRIBERS.
            new TestRunnerExecutionStarted(),
            new TestRunnerConfiguredSubscriber(),
            // TESTSUITE SUBSCRIBERS.
            new TestSuiteFinishedSubscriber($configuration),
            // TEST SUBSCRIBERS.
            new TestFinishedSubscriber(),
            // TEST OUTCOME SUBSCRIBERS.
            new TestPassedSubscriber(),
            new TestFailedSubscriber(),
            new TestErroredSubscriber(),
            new TestMarkedInCompleteSubscriber(),
            new TestSkippedSubscriber(),
        );
    }
}
