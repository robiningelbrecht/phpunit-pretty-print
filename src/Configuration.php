<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $convertMethodNamesToSentences,
        private readonly bool $displayQuote,
        private readonly bool $useCompactMode,
    ) {
    }

    public function convertMethodNamesToSentences(): bool
    {
        return $this->convertMethodNamesToSentences;
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
        return new self(
            $parameters->has('convertMethodNamesToSentences') && $parameters->get('convertMethodNamesToSentences'),
            $parameters->has('displayQuote') && $parameters->get('displayQuote'),
            $parameters->has('useCompactMode') && $parameters->get('useCompactMode'),
        );
    }
}
