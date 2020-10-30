<?php

namespace Spatie\Once\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Once\Cache;

class CacheTest extends TestCase
{
    /** @test */
    public function it_will_forget_objects()
    {
        $testClassA = $this->newTestClass();
        $testClassB = $this->newTestClass();

        $firstResultA = $testClassA->getNumber();
        $firstStaticResult = $testClassA::getStaticNumber();
        $firstResultB = $testClassB->getNumber();

        $this->assertSame($firstResultA, $testClassA->getNumber());
        $this->assertSame($firstStaticResult, $testClassA::getStaticNumber());
        $this->assertSame($firstResultB, $testClassB->getNumber());

        Cache::forgetObject(get_class($testClassA));
        $secondStaticResult = $testClassA::getStaticNumber();
        $this->assertNotEquals($firstStaticResult, $secondStaticResult);
        $this->assertSame($secondStaticResult, $testClassA::getStaticNumber());
        $this->assertSame($firstResultA, $testClassA->getNumber());
        $this->assertSame($firstResultB, $testClassB->getNumber());

        Cache::forgetObject($testClassA);
        $secondResultA = $testClassA->getNumber();
        $this->assertNotEquals($firstResultA, $secondResultA);
        $this->assertSame($secondResultA, $testClassA->getNumber());
        $this->assertSame($firstResultB, $testClassB->getNumber());
    }

    public function newTestClass()
    {
        return new class() {
            public function getNumber()
            {
                return once(function () {
                    return random_int(1, 10000000);
                });
            }

            public static function getStaticNumber()
            {
                return once(function () {
                    return random_int(1, 10000000);
                });
            }
        };
    }
}
