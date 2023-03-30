<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

enum Icon: string
{
    case PASSED = '✓';
    case FAILED = '⨯';
    case WARNING = '!';

    public function getColor(): string
    {
        return match ($this) {
            self::PASSED => 'green',
            self::FAILED => 'red',
            self::WARNING => 'yellow',
        };
    }
}
