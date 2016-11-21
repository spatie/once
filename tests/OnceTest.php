<?php

namespace Spatie\Once\Test;

require __DIR__ . '/TestClass.php';
use PHPUnit_Framework_TestCase;

class OnceTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_will_run_the_a_callback_without_arguments_only_once()
    {
        $testClass = new TestClass;

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
        $testClass = new TestClass;


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
        $testClass = new TestClass;
          
        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());
        $this->assertNull($testClass->getNull());

        $this->assertEquals(1, $testClass->counter);
    }
}
