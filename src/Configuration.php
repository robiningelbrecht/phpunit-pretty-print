<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $prettifyMethodNames,
        private readonly bool $displayQuote,
        private readonly bool $useCompactMode,
    ) {
    }

    public function prettifyMethodNames(): bool
    {
        return $this->prettifyMethodNames;
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
        if (!$prettifyMethodNames = in_array('--prettify-method-names', $_SERVER['argv'], true)) {
            $prettifyMethodNames = $parameters->has('prettifyMethodNames') && $parameters->get('prettifyMethodNames');
        }
        if (!$useCompactMode = in_array('--compact', $_SERVER['argv'], true)) {
            $useCompactMode = $parameters->has('useCompactMode') && $parameters->get('useCompactMode');
        }
        if (!$displayQuote = in_array('--display-quote', $_SERVER['argv'], true)) {
            $displayQuote = $parameters->has('displayQuote') && $parameters->get('displayQuote');
        }

        return new self(
            $prettifyMethodNames,
            $displayQuote,
            $useCompactMode,
        );
    }
}
