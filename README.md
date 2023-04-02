<h1 align="center">Better PHPUnit CLI output</h1>

<p align="center">
	<img src="readme/phpunit.png" alt="PHPUnit">
</p>

---

I really like how [Pest PHP](https://pestphp.com/) formats and outputs test results, 
but I still prefer to use [PHPUnit](https://phpunit.de/). 
That's why I decided to build a plugin that allows you to output test results just like Pest PHP does.

## Installation

```bash
composer require robiningelbrecht/phpunit-pretty-print --dev
```

This package requires:
* PHP `^8.1 || ^8.2`
* PHPUnit `^10`

## Configuration

Navigate to your `phpunit.xml.dist` file and add following config to set default options 
(you can also set these options at run time):

```xml
<extensions>
    <bootstrap class="RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension">
    </bootstrap>
</extensions>
```

### Options

* Prettify the method names that PHPUnit outputs

```xml
<extensions>
    <bootstrap class="RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension">
        <parameter name="prettifyMethodNames" value="true"/>
    </bootstrap>
</extensions>
```

* Use compact mode to only output the testsuite results instead of all separate test

```xml
<extensions>
    <bootstrap class="RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension">
        <parameter name="useCompactMode" value="true"/>
    </bootstrap>
</extensions>
```

* Feel good about yourself after running your testsuite by displaying a Chuck Noris quote

```xml
<extensions>
    <bootstrap class="RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension">
        <parameter name="displayQuote" value="true"/>
    </bootstrap>
</extensions>
```

## Usage

Just run your testsuite like you normally would, but be sure to add `--no-output`* as an argument.

```bash
vendor/bin/phpunit --no-ouput
```

*<sub>We'll need this until https://github.com/sebastianbergmann/phpunit/issues/5168 lands and gets released.</sub>

Prettify the method names

```bash
vendor/bin/phpunit --no-output -d --prettify-method-names
```

Use compact mode

```bash
vendor/bin/phpunit --no-output -d --compact
```

Display Chuck Norris quote

```bash
vendor/bin/phpunit --no-output -d --display-quote
```

Combine multiple options

```bash
vendor/bin/phpunit --configuration=tests/phpunit.test.xml --no-output -d --compact -d --display-quote
```

<p align="center">
	<img src="readme/example.png" alt="Example">
</p>

## Acknowledgements

* API used for Chuck Noris quotes: https://api.chucknorris.io/
* CLI output based on https://pestphp.com/
* Code to format methods to human-readable sentences from https://github.com/indentno/phpunit-pretty-print

