<?php

namespace Spatie\Once\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Once\Cache;

class OnceTest extends TestCase
{
    private Cache $cache;

    public function setUp(): void
    {
        $this->cache = Cache::getInstance();

        $this->cache->enable();
        $this->cache->flush();

        parent::setUp();
    }

    /** @test */
    public function it_will_run_the_a_callback_without_arguments_only_once()
    {
        $testClass = new class() {
            public function getNumber()
            {
                return once(function () {
                    return rand(1, 10000000);
                });
            }
        };

        $firstResult = $testClass->getNumber();

        $this->assertGreaterThanOrEqual(1, $firstResult);
        $this->assertLessThanOrEqual(10000000, $firstResult);

        foreach (range(1, 100) as $i) {
            $this->assertEquals($firstResult, $testClass->getNumber());
        }
    }

    /** @test */
    public function it_will_run_the_given_callback_only_once_per_variation_arguments_in_use()
    {
        $testClass = new class() {
            public function getNumberForLetter($letter)
            {
                return once(function () use ($letter) {
                    return $letter.rand(1, 10000000);
                });
            }
        };

        foreach (range('A', 'Z') as $letter) {
            $firstResult = $testClass->getNumberForLetter($letter);
            $this->assertStringStartsWith($letter, $firstResult);

            foreach (range(1, 100) as $i) {
                $this->assertEquals($firstResult, $testClass->getNumberForLetter($letter));
            }
        }
    }

    /** @test */
    public function it_will_run_the_given_callback_only_once_for_falsy_result()
    {
        $testClass = new class() {
            public $counter = 0;

            public function getNull()
            {
                return once(function () {
                    $this->counter++;
                });
            }
        };

        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());

        $this->assertEquals(1, $testClass->counter);
    }

    /** @test */
    public function it_will_work_properly_with_unset_objects()
    {
        $previousNumbers = [];

        foreach (range(1, 5) as $number) {
            $testClass = new TestClass();

            $number = $testClass->getRandomNumber();

            $this->assertNotContains($number, $previousNumbers);

            $previousNumbers[] = $number;

            unset($testClass);
        }
    }

    /** @test */
    public function it_will_remember_the_memoized_value_when_serialized_when_called_in_the_same_request()
    {
        $testClass = new TestClass();

        $firstNumber = $testClass->getRandomNumber();

        $this->assertEquals($firstNumber, $testClass->getRandomNumber());

        $serialized = serialize($testClass);
        $unserialized = unserialize($serialized);
        unset($unserialized);

        $this->assertEquals($firstNumber, $testClass->getRandomNumber());
    }

    /** @test */
    public function it_will_run_callback_once_on_static_method()
    {
        $object = new class() {
            public static function getNumber()
            {
                return once(function () {
                    return rand(1, 10000000);
                });
            }
        };
        $class = get_class($object);

        $firstResult = $class::getNumber();

        $this->assertGreaterThanOrEqual(1, $firstResult);
        $this->assertLessThanOrEqual(10000000, $firstResult);

        foreach (range(1, 100) as $i) {
            $this->assertEquals($firstResult, $class::getNumber());
        }
    }

    /** @test */
    public function it_will_run_callback_once_on_static_method_per_variation_arguments_in_use()
    {
        $object = new class() {
            public static function getNumberForLetter($letter)
            {
                return once(function () use ($letter) {
                    return $letter.rand(1, 10000000);
                });
            }
        };
        $class = get_class($object);

        foreach (range('A', 'Z') as $letter) {
            $firstResult = $class::getNumberForLetter($letter);
            $this->assertStringStartsWith($letter, $firstResult);

            foreach (range(1, 100) as $i) {
                $this->assertEquals($firstResult, $class::getNumberForLetter($letter));
            }
        }
    }

    /** @test */
    public function it_can_flush_the_entire_cache()
    {
        $testClass = new class() {
            public function getNumber()
            {
                return once(function () {
                    return random_int(1, 10000000);
                });
            }
        };

        $firstResult = $testClass->getNumber();

        Cache::getInstance()->flush();

        $this->assertNotEquals($firstResult, $testClass->getNumber());
    }

    /** @test */
    public function it_can_enable_and_disable_the_cache()
    {
        $testClass = new class() {
            public function getNumber()
            {
                return once(function () {
                    return random_int(1, 10000000);
                });
            }
        };

        $this->assertTrue($this->cache->isEnabled());
        $this->assertEquals($testClass->getNumber(), $testClass->getNumber());

        $this->cache->disable();
        $this->assertFalse($this->cache->isEnabled());
        $this->assertNotEquals($testClass->getNumber(), $testClass->getNumber());

        $this->cache->enable();
        $this->assertTrue($this->cache->isEnabled());
        $this->assertEquals($testClass->getNumber(), $testClass->getNumber());
    }

    /** @test */
    public function it_will_not_throw_error_with_eval()
    {
        $result = eval('return once( function () { return random_int(1, 1000); } ) ;');

        $this->assertTrue(in_array($result, range(1, 1000)));
    }

    /** @test */
    public function it_will_differentiate_between_closures()
    {
        $testClass = new class() {
            public function getNumber()
            {
                $closure = function () {
                    return once(function () {
                        return random_int(1, 1000);
                    });
                };

                return $closure();
            }

            public function secondNumber()
            {
                $closure = function () {
                    return once(function () {
                        return random_int(1001, 2000);
                    });
                };

                return $closure();
            }
        };

        $this->assertNotEquals($testClass->getNumber(), $testClass->secondNumber());
    }

    /** @test */
    public function it_will_run_callback_once_for_closure_called_on_differemt_lines()
    {
        $testClass = new class() {
            public function getNumbers()
            {
                $closure = function () {
                    return once(function () {
                        return random_int(1, 10000000);
                    });
                };

                $numbers[] = $closure();
                $numbers[] = $closure();

                return $numbers;
            }
        };

        $results = $testClass->getNumbers();
        $this->assertEquals($results[0], $results[1]);
    }

    /** @test */
    public function it_will_work_in_global_functions()
    {
        function globalFunction()
        {
            return once(function () {
                return random_int(1, 10000000);
            });
        }

        $this->assertEquals(globalFunction(), globalFunction());
    }
}
