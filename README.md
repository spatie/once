# A magic [memoization](https://en.wikipedia.org/wiki/Memoization) function

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/once.svg?style=flat-square)](https://packagist.org/packages/spatie/once)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/once/master.svg?style=flat-square)](https://travis-ci.org/spatie/once)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/once.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/once)
[![StyleCI](https://styleci.io/repos/73020509/shield?branch=master)](https://styleci.io/repos/73020509)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/once.svg?style=flat-square)](https://packagist.org/packages/spatie/once)

This package contains a `once` function. You can pass a `callable` to it. Here's quick example:

```php
$myClass = new class() {
    public function getNumber()
    {
        return once(function () {
            return rand(1, 10000);
        });
    }
};
```

No matter how many times you run `$myClass->getNumber()` inside the same request  you'll always get the same number.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/once.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/once)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/once
```

## Usage

The `once` function accepts a `callable`.

```php
$myClass = new class() {
    public function getNumber()
    {
        return once(function () {
            return rand(1, 10000);
        });
    }
};
```

No matter how many times you run `$myClass->getNumber()` you'll always get the same number.

The `once` function will only run once per combination of argument values the containing method receives.

```php
class MyClass
{
    /**
     * It also works in static context!
     */
    public static function getNumberForLetter($letter)
    {
        return once(function () use ($letter) {
            return $letter . rand(1, 10000000);
        });
    }
}
```

So calling `MyClass::getNumberForLetter('A')` will always return the same result, but calling `MyClass::getNumberForLetter('B')` will return something else.

### Flushing the cache

To flush the entire cache you can call:

```php
Spatie\Once\Cache::flush();
```

### Disabling the cache

In your test you probably don't want to cache values. To disable the cache you can call:

```php
Spatie\Once\Cache::disable();
```

You can re-enable the cache with

```php
Spatie\Once\Cache::enable();
```

## Behind the curtains

Let's go over [the code of the `once` function](https://github.com/spatie/once/blob/0dbfc37/src/functions.php) to learn how all the magic works.

In short: it will execute the given callable and save the result in the static `$values` property of `Spatie\Once\Cache`. When we detect that `once` has already run before, we're just going to return the value stored inside the `$values` array instead of executing the callable again.

The first thing it does is calling [`debug_backtrace`](http://php.net/manual/en/function.debug-backtrace.php). We'll use the output to determine in which function and class `once` is called and to get access to the `object` that function is running in. Yeah, we're already in voodoo-land. The output of the `debug_backtrace` is passed to a new instance of `Backtrace`. That class is just a simple wrapper so we can work more easily with the backtrace.

```php
$trace = debug_backtrace(
    DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
)[1];

$backtrace = new Backtrace($trace);

$object = $backtrace->getObject();
```

Next, we calculate a `hash` of the backtrace. This hash will be unique per function `once` was called in and the values of the arguments that function receives.

```php
$hash = $backtrace->getHash();
```

Finally we will check if there's already a value stored for the given hash. If not, then execute the given `$callback` and store the result in `Spatie\Once\Cache`. In the other case just return the value from that cache (the `$callback` isn't executed).

```php
if (! Cache::has($object, $hash)) {
    $result = call_user_func($callback, $backtrace->getArguments());

    Cache::set($object, $hash, $result);
}

return Cache::get($object, $hash);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

Credit for the idea of the `once` function goes to [Taylor Otwell](https://twitter.com/taylorotwell/status/794622206567444481). The code for this package is based upon the code he was kind enough to share with us.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
