<?php

namespace Spatie\Once\Test;

class TestClass 
{
    public $counter = 0;

    public function getNull()
    {
        return once(function () {
            $this->counter++;
        });
    }

    
    public function getNumber()
    {
        return once(function () {
            return rand(1, 10000000);
        });
    }
    
    public function getNumberForLetter($letter)
    {
        return once(function () use ($letter) {
            return $letter.rand(1, 10000000);
        });
    } 
}
