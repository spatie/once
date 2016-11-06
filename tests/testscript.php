<?php

include('vendor/autoload.php');

function getNumber()
{
    return once(function () {
        return rand(1, 10000000);
    });
}

$firstNumber = getNumber();

foreach(range(1,10000) as $i) {
    $newNumber = getNumber();
    if ($newNumber !== $firstNumber) {
        throw new Exception("Did not get equal results. Firstnumber {$firstNumber} is not same as {$newNumber}");
    }
}

echo 'all ok';
