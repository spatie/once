<?php

namespace Spatie\Once\Test;

class TestClass
{
    public function getRandomNumber()
    {
        return once(function () {

            return rand(1,10000000000);

        });
    }
}