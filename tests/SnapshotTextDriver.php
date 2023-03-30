<?php

namespace Tests;

use Spatie\Snapshots\Drivers\TextDriver;

class SnapshotTextDriver extends TextDriver
{
    public function serialize($data): string
    {
        return parent::serialize($this->applyPregReplace($data));
    }

    public function match($expected, $actual): void
    {
        parent::match($expected, $this->applyPregReplace($actual));
    }

    private function applyPregReplace(string $data): string
    {
        $regexes = [
            '/[0-9]+.[0-9]+s|0s/' => 'DURATION-IN-SECONDS',
            '/PHPUnit [\S]+ using PHP [\S]+ \(cli\) on [\S]+/' => 'PHPUnit SOME-PHPUNIT-VERSION using PHP SOME-PHP-VERSION (cli) on SOME-OS',
        ];

        foreach ($regexes as $regex => $replacement) {
            $data = preg_replace($regex, $replacement, $data);
        }

        return $data;
    }
}
