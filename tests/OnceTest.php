<?php

namespace Spatie\Once\Test;

use PHPUnit_Framework_TestCase;

class OnceTest extends PHPUnit_Framework_TestCase
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
            public function getNumber($letter)
            {
                return once(function () use ($letter) {
                    return $letter.rand(1, 10000000);
                });
            }
        };

        foreach (range('A', 'Z') as $letter) {
            $firstResult = $testClass->getNumber($letter);
            $this->assertStringStartsWith($letter, $firstResult);

            foreach (range(1, 100) as $i) {
                $this->assertEquals($firstResult, $testClass->getNumber($letter));
            }
        }
    }
}
