<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $convertMethodNamesToSentences,
        private readonly bool $displayQuotesForName,
        private readonly ?string $nameToUSeInQuotes,
    ) {
    }

    public function convertMethodNamesToSentences(): bool
    {
        return $this->convertMethodNamesToSentences;
    }

    public function displayQuotesForName(): bool
    {
        return $this->displayQuotesForName;
    }

    public function getNameToUseInQuotes(): ?string
    {
        return $this->nameToUSeInQuotes;
    }

    public static function fromParameterCollection(ParameterCollection $parameters): self
    {
        return new self(
            $parameters->has('convertMethodNamesToSentences') && $parameters->get('convertMethodNamesToSentences'),
            $parameters->has('displayQuotesForName'),
            $parameters->has('displayQuotesForName') ? $parameters->get('displayQuotesForName') : null
        );
    }
}
