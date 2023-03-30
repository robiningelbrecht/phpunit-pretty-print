# phpunit-pretty-print
Better PHPUnit CLI output

```bash
vendor/bin/phpunit --configuration=tests/phpunit.test.xml --no-output
vendor/bin/phpunit --configuration=tests/phpunit.test-with-method-name-conversion.xml --no-output
vendor/bin/phpunit --configuration=tests/phpunit.test-with-quotes.xml --no-output
```

```xml
  <extensions>
    <bootstrap class="RobinIngelbrecht\PHPUnitPrettyPrint\PhpUnitExtension">
      <parameter name="convertMethodNamesToSentences" value="true"/>
      <parameter name="displayQuotesForName" value="Robin"/>
    </bootstrap>
  </extensions>
```

https://github.com/skolakoda/programming-quotes-api
https://api.chucknorris.io/jokes/random?category=dev