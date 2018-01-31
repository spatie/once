<?php

namespace Spatie\Once\Test;

class TestClass
{
    /** @var int */
    protected $number;

    public function __construct()
    {
        $this->number = rand(1, 1000000);
    }

    public function getProtectedNumber()
    {
        return once(function () {
            return $this->number;
        });
    }
}
