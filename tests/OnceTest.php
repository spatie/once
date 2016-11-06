<?php

namespace Spatie\Once\Test;

use PHPUnit_Framework_TestCase;

class OnceTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_will_run_the_given_callback_only_once()
    {
        $testClass = new class {
            public function getNumber()
            {
                return once(function() {
                   return rand(1,10000000);
                });
            }
        };

        $firstResult = $testClass->getNumber();

        $this->assertGreaterThanOrEqual(1, $firstResult);
        $this->assertLessThanOrEqual(10000000, $firstResult);

        foreach(range(1, 1000) as $i) {
            $this->assertEquals($firstResult, $testClass->getNumber());
        }
    }
}
