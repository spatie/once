<?php

namespace Spatie\Once\Test;

class TestClass
{
    /** @var int */
    protected $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getNumber()
    {
        return once(function () {

            return $this->number;

        });
    }
}