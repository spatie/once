<?php

namespace Spatie\Once\Test;

use PHPUnit_Framework_TestCase;

class OnceTest extends PHPUnit_Framework_TestCase
{
    private $counter = 0;
    
    private function getNull()
    {
        return once(function () {
            $this->counter++;
        });
    }
    
    private function getNumber()
    {
        return once(function () {
            return rand(1, 10000000);
        });
    }
    
    private function getNumberForLetter($letter)
    {
        return once(function () use ($letter) {
            return $letter.rand(1, 10000000);
        });
    } 
    
    /** @test */
    public function it_will_run_the_a_callback_without_arguments_only_once()
    {
        $testClass = $this;

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
        $testClass = $this;


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
        $testClass = $this;
          
        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());

        $this->assertEquals(1, $testClass->counter);
    }
}
