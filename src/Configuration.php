<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $displayProfiling,
        private readonly bool $displayQuote,
        private readonly bool $useCompactMode,
    ) {
    }

    public function displayProfiling(): bool
    {
        return $this->displayProfiling;
    }

    public function displayQuote(): bool
    {
        return $this->displayQuote;
    }

    public function useCompactMode(): bool
    {
        return $this->useCompactMode;
    }

    public static function fromParameterCollection(ParameterCollection $parameters): self
    {
        if (!$useProfiling = in_array('--profiling', $_SERVER['argv'], true)) {
            $useProfiling = $parameters->has('displayProfiling') && !self::isFalsy($parameters->get('displayProfiling'));
        }
        if (!$useCompactMode = in_array('--compact', $_SERVER['argv'], true)) {
            $useCompactMode = $parameters->has('useCompactMode') && !self::isFalsy($parameters->get('useCompactMode'));
        }
        if (!$displayQuote = in_array('--display-quote', $_SERVER['argv'], true)) {
            $displayQuote = $parameters->has('displayQuote') && !self::isFalsy($parameters->get('displayQuote'));
        }

        return new self(
            $useProfiling,
            $displayQuote,
            $useCompactMode,
        );
    }

    public static function isFalsy(mixed $value): bool
    {
        if (is_bool($value)) {
            return !$value;
        }
        if ('true' === $value) {
            return false;
        }
        if ('false' === $value) {
            return true;
        }
        if (is_int($value)) {
            return !$value;
        }

        return true;
    }
}
