<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $profiling,
        private readonly bool $displayQuote,
        private readonly bool $useCompactMode,
    ) {
    }

    public function useProfiling(): bool
    {
        return $this->profiling;
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
            $useProfiling = $parameters->has('useProfiling') && $parameters->get('useProfiling');
        }
        if (!$useCompactMode = in_array('--compact', $_SERVER['argv'], true)) {
            $useCompactMode = $parameters->has('useCompactMode') && $parameters->get('useCompactMode');
        }
        if (!$displayQuote = in_array('--display-quote', $_SERVER['argv'], true)) {
            $displayQuote = $parameters->has('displayQuote') && $parameters->get('displayQuote');
        }

        return new self(
            $useProfiling,
            $displayQuote,
            $useCompactMode,
        );
    }
}
