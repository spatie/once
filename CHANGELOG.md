# Changelog

All notable changes to `once` will be documented in this file

## 3.1.2 - 2025-11-25

### What's Changed

* Bump dependabot/fetch-metadata from 1.6.0 to 2.1.0 by @dependabot[bot] in https://github.com/spatie/once/pull/97
* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot[bot] in https://github.com/spatie/once/pull/102
* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot[bot] in https://github.com/spatie/once/pull/103
* Bump dependabot/fetch-metadata from 2.3.0 to 2.4.0 by @dependabot[bot] in https://github.com/spatie/once/pull/104
* Update issue template by @AlexVanderbist in https://github.com/spatie/once/pull/107
* Bump stefanzweifel/git-auto-commit-action from 4 to 7 by @dependabot[bot] in https://github.com/spatie/once/pull/108
* Bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/spatie/once/pull/106
* Added Symfony 8 support to all symfony/* packages. by @thecaliskan in https://github.com/spatie/once/pull/110
* Bump actions/checkout from 5 to 6 by @dependabot[bot] in https://github.com/spatie/once/pull/111

### New Contributors

* @AlexVanderbist made their first contribution in https://github.com/spatie/once/pull/107
* @thecaliskan made their first contribution in https://github.com/spatie/once/pull/110

**Full Changelog**: https://github.com/spatie/once/compare/3.1.1...3.1.2

## 3.1.1 - 2024-05-27

### What's Changed

* fix spacing by @faisuc in https://github.com/spatie/once/pull/77
* Add Dependabot Automation by @patinthehat in https://github.com/spatie/once/pull/80
* Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/once/pull/82
* Update Dependabot Automation by @patinthehat in https://github.com/spatie/once/pull/83
* Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/spatie/once/pull/84
* Update README.md by @davidjr82 in https://github.com/spatie/once/pull/87
* Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/spatie/once/pull/89
* Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/spatie/once/pull/90
* Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/spatie/once/pull/93
* Bump actions/checkout from 2 to 4 by @dependabot in https://github.com/spatie/once/pull/94
* Adjust pretty name of closures on PHP 8.4 by @staabm in https://github.com/spatie/once/pull/99

### New Contributors

* @faisuc made their first contribution in https://github.com/spatie/once/pull/77
* @patinthehat made their first contribution in https://github.com/spatie/once/pull/80
* @dependabot made their first contribution in https://github.com/spatie/once/pull/84
* @davidjr82 made their first contribution in https://github.com/spatie/once/pull/87
* @staabm made their first contribution in https://github.com/spatie/once/pull/99

**Full Changelog**: https://github.com/spatie/once/compare/3.1.0...3.1.1

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
