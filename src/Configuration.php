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
            $useProfiling = $parameters->has('displayProfiling') && $parameters->get('displayProfiling');
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
