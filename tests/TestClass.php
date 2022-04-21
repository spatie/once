<?php

namespace Spatie\Once\Test;

class TestClass
{
    protected int $randomNumber;

    public function __construct()
    {
        $this->randomNumber = rand(1, 1000000);
    }

    public function getRandomNumber()
    {
        return once(function () {
            return $this->randomNumber;
        });
    }
}
