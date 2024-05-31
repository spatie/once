<?php

namespace Spatie\Once\Test;

use Spatie\Once\Cache;

beforeEach(function () {
    $this->cache = Cache::getInstance();
    $this->cache->enable();
    $this->cache->flush();
});

it('will run the given callback without arguments only once, if condition is true', function () {
    $testClass = new class() {
        public function getNumber()
        {
            return onceIf(true, function () {
                return rand(1, 10000000);
            });
        }
    };

    $firstResult = $testClass->getNumber();

    expect($firstResult)->toBeGreaterThanOrEqual(1);
    expect($firstResult)->toBeLessThanOrEqual(10000000);

    foreach (range(1, 100) as $i) {
        expect($testClass->getNumber())->toBe($firstResult);
    }
});

it('will run the given callback without arguments several times, if condition is false', function () {
    $testClass = new class() {
        public function getNumber()
        {
            return onceIf(false, function () {
                return rand(1, 10000000);
            });
        }
    };

    $firstResult = $testClass->getNumber();

    expect($firstResult)->toBeGreaterThanOrEqual(1);
    expect($firstResult)->toBeLessThanOrEqual(10000000);

    foreach (range(1, 100) as $i) {
        expect($testClass->getNumber())->not()->toBe($firstResult);
    }
});

it('will run the given callback without arguments only once, if condition is a "true" callable', function () {
    $testClass = new class() {
        public function getNumber()
        {
            return onceIf(fn() => true, function () {
                return rand(1, 10000000);
            });
        }
    };

    $firstResult = $testClass->getNumber();

    expect($firstResult)->toBeGreaterThanOrEqual(1);
    expect($firstResult)->toBeLessThanOrEqual(10000000);

    foreach (range(1, 100) as $i) {
        expect($testClass->getNumber())->toBe($firstResult);
    }
});

it('will run the given callback without arguments several times, if condition is a "false" callable', function () {
    $testClass = new class() {
        public function getNumber()
        {
            return onceIf(fn() => false, function () {
                return rand(1, 10000000);
            });
        }
    };

    $firstResult = $testClass->getNumber();

    expect($firstResult)->toBeGreaterThanOrEqual(1);
    expect($firstResult)->toBeLessThanOrEqual(10000000);

    foreach (range(1, 100) as $i) {
        expect($testClass->getNumber())->not()->toBe($firstResult);
    }
});
