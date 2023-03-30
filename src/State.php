<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

final class State
{
    private const TOTAL_TEST_COUNT = 'total_test_count';
    private const TOTAL_ASSERTION_COUNT = 'total_assertion_count';
    private const TOTAL_TEST_PASSED_COUNT = 'total_test_passed_count';

    public static function incrementTotalTestCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TEST_COUNT, 1);
    }

    public static function getTotalTestCount(): int
    {
        return $GLOBALS[self::TOTAL_TEST_COUNT] ?? 0;
    }

    public static function incrementTotalTestPassedCount(): void
    {
        self::incrementCountForKeyWith(self::TOTAL_TEST_PASSED_COUNT, 1);
    }

    public static function getTotalTestPassedCount(): int
    {
        return $GLOBALS[self::TOTAL_TEST_PASSED_COUNT] ?? 0;
    }

    public static function incrementTotalAssertionCountWith(int $increment): void
    {
        self::incrementCountForKeyWith(self::TOTAL_ASSERTION_COUNT, $increment);
    }

    public static function getTotalAssertionCount(): int
    {
        return $GLOBALS[self::TOTAL_ASSERTION_COUNT] ?? 0;
    }

    private static function incrementCountForKeyWith(string $key, int $increment): void
    {
        if (!array_key_exists($key, $GLOBALS)) {
            $GLOBALS[$key] = 0;
        }

        $GLOBALS[$key] += $increment;
    }
}
