# Changelog

All notable changes to `once` will be documented in this file

## 3.1.0 - 2022-04-21

## What's Changed

- Rewrite phpunit tests to pest by @otsch in https://github.com/spatie/once/pull/73

## New Contributors

- @otsch made their first contribution in https://github.com/spatie/once/pull/73

**Full Changelog**: https://github.com/spatie/once/compare/3.0.2...3.1.0

## 3.0.2 - 2022-02-04

## What's Changed

- Add PHPStan doc blocks by @ThibaudDauce in https://github.com/spatie/once/pull/72

**Full Changelog**: https://github.com/spatie/once/compare/3.0.1...3.0.2

## 3.0.1 - 2021-07-04

- fix for caching static functions of different classes with the same name (#62)

## 3.0.0 - 2020-11-04

- refactor to use a `WeakMap`
- drop support for PHP 7

## 2.2.1 - 2020-09-29

- allow PHP 8

## 2.2.0 - 2020-02-18

- support global functions

## 2.1.3 - 2019-10-31

- differentiate between closures (#42)

## 2.1.2 - 2019-08-05

- remove excess parameter in `get` on `cache`

## 2.1.1 - 2019-06-27

- do not throw an error when using `once` in `eval`

## 2.1.0 - 2019-06-19

- add enabling/disable the cache
- add `flush` method
- drop support for PHP 7.1 and below

## 2.0.2 - 2018-12-27

- add ability to use `once` in static functions

## 2.0.1 - 2018-01-31

- improvements around serialization

## 2.0.0 - 2018-01-31

- ditch `__memoized` in favor of `Spatie\Once\Cache`

## 1.1.0 - 2017-08-24

- add `MemoizeAwareTrait`

## 1.0.1 - 2016-11-14

- fix cacheability of falsy return values

## 1.0.0 - 2016-11-07

- initial release
