<?php

namespace Tests;

use Spatie\Snapshots\Drivers\TextDriver;

class SnapshotTextDriver extends TextDriver
{
    public function serialize(mixed $data): string
    {
        return parent::serialize($this->applyPregReplace($data));
    }

    public function match(mixed $expected, mixed $actual): void
    {
        parent::match($expected, $this->applyPregReplace($actual));
    }

    private function applyPregReplace(mixed $data): ?string
    {
        $regexes = [
            '/[\s]+[0-9]+.[0-9]+s|0s/' => ' DURATION-IN-SECONDS',
            '/\/(.*?)\/tests\/ExampleTests/' => '/tests/ExampleTests',
            '/FAILED(.*?)>(.*?)[ ]{3,}([\S]+)/' => 'FAILED$1>$2 $3',
            '/─[\S]*─/' => '───────────────────',
            '/([\d]+.[\d]+)%/' => 'SOME-PERCENTAGE',
        ];

        foreach ($regexes as $regex => $replacement) {
            $data = preg_replace($regex, $replacement, $data);
        }

        return $data;
    }
}
