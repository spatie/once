<?php

namespace Spatie\Once\Test;

use PHPUnit\Framework\TestCase;

class OnceTest extends TestCase
{
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
}
