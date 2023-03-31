<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

// We'll need this until https://github.com/sebastianbergmann/phpunit/issues/5292 lands.
final class State
{
    private const TOTAL_TEST_COUNT = 'total_test_count';
    private const TOTAL_ASSERTION_COUNT = 'total_assertion_count';
    private const TOTAL_TESTS_PASSED_COUNT = 'total_tests_passed_count';
    private const TOTAL_TESTS_FAILED_COUNT = 'total_tests_failed_count';
    private const TOTAL_TESTS_ERRORED_COUNT = 'total_tests_errored_count';
    private const TOTAL_TESTS_MARKED_INCOMPLETE_COUNT = 'total_tests_marked_incomplete_count';
    private const TOTAL_TESTS_SKIPPED_COUNT = 'total_tests_skipped_count';

    private const THROWABLES = 'throwables';

    public static function incrementTotalTestCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TEST_COUNT, 1);
    }

    public static function getTotalTestCount(): int
    {
        return $GLOBALS[self::TOTAL_TEST_COUNT] ?? 0;
    }

    public static function incrementTotalTestsPassedCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TESTS_PASSED_COUNT, 1);
    }

    public static function getTotalTestsPassedCount(): int
    {
        return $GLOBALS[self::TOTAL_TESTS_PASSED_COUNT] ?? 0;
    }

    public static function incrementTotalTestsFailedCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TESTS_FAILED_COUNT, 1);
    }

    public static function getTotalTestsFailedCount(): int
    {
        return $GLOBALS[self::TOTAL_TESTS_FAILED_COUNT] ?? 0;
    }

    public static function incrementTotalTestsErroredCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TESTS_ERRORED_COUNT, 1);
    }

    public static function getTotalTestsErroredCount(): int
    {
        return $GLOBALS[self::TOTAL_TESTS_ERRORED_COUNT] ?? 0;
    }

    public static function incrementTotalTestsMarkedIncompleteCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TESTS_MARKED_INCOMPLETE_COUNT, 1);
    }

    public static function getTotalTestsMarkedIncompleteCount(): int
    {
        return $GLOBALS[self::TOTAL_TESTS_MARKED_INCOMPLETE_COUNT] ?? 0;
    }

    public static function incrementTotalTestsSkippedCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TESTS_SKIPPED_COUNT, 1);
    }

    public static function getTotalTestsSkippedCount(): int
    {
        return $GLOBALS[self::TOTAL_TESTS_SKIPPED_COUNT] ?? 0;
    }

    public static function incrementTotalAssertionCountWith(int $increment): void
    {
        self::incrementCountForKeyWith(self::TOTAL_ASSERTION_COUNT, $increment);
    }

    public static function getTotalAssertionCount(): int
    {
        return $GLOBALS[self::TOTAL_ASSERTION_COUNT] ?? 0;
    }

    public static function addThrowable(Throwable $throwable): void
    {
        $GLOBALS[self::THROWABLES][] = $throwable;
    }

    /**
     * @return \RobinIngelbrecht\PHPUnitPrettyPrint\Throwable[]
     */
    public static function getThrowables(): array
    {
        return $GLOBALS[self::THROWABLES] ?? [];
    }

    private static function incrementCountForKeyWith(string $key, int $increment): void
    {
        if (!array_key_exists($key, $GLOBALS)) {
            $GLOBALS[$key] = 0;
        }

        $GLOBALS[$key] += $increment;
    }
}
