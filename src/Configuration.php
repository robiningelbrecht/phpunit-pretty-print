<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $convertMethodNamesToSentences,
        private readonly bool $displayQuote,
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

    public static function fromParameterCollection(ParameterCollection $parameters): self
    {
        return new self(
            $parameters->has('convertMethodNamesToSentences') && $parameters->get('convertMethodNamesToSentences'),
            $parameters->has('displayQuote') && $parameters->get('displayQuote'),
        );
    }
}
