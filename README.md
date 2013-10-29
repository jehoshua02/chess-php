# Chess PHP [![Build Status](https://travis-ci.org/jehoshua02/chess-php.png?branch=master)](https://travis-ci.org/jehoshua02/chess-php)

Using the classical game of chess as a subject for Test Driven Development!


## Running Tests

The `tests/` are written using the [PHPUnit](http://phpunit.de/manual/current/en/index.html) library, installed via [Composer](http://getcomposer.org/). Install with Composer like so:

```
$ composer install --dev
```

The [PHPUnit command-line test runner](http://phpunit.de/manual/current/en/textui.html) will be installed in `vendor/` rather than in some global system location. Run the `tests/` like so:

```
$ ./vendor/bin/phpunit
```
