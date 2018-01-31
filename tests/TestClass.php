<?php

namespace Spatie\Once\Test;

class TestClass
{
    /** @var int */
    protected $randomNumber;

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
