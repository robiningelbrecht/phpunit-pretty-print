<?php

namespace Tests;

use Symfony\Component\Console\Output\NullOutput;

class SpyOutput extends NullOutput implements \Stringable
{
    private array $messages = [];

    public function writeln(string|iterable $messages, int $options = self::OUTPUT_NORMAL): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        $this->messages = [...$this->messages, ...$messages];
    }

    public function write(string|iterable $messages, bool $newline = false, int $options = self::OUTPUT_NORMAL): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        $this->messages = [...$this->messages, ...$messages];
    }

    public function __toString(): string
    {
        return implode(PHP_EOL, $this->messages);
    }
}
