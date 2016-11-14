<?php

use Spatie\Once\Backtrace;

function once($callback)
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
    )[1];

    $backtrace = new Backtrace($trace);

    if (! $object = $backtrace->getObject()) {
        throw new Exception('Cannot use `once` outside a non-static method of a class');
    }

    $hash = $backtrace->getHash();

    $cacheHit = isset($object->__memoized) && array_key_exists($hash, $object->__memoized);

    if (! $cacheHit) {
        $result = call_user_func($callback, $backtrace->getArguments());

        $object->__memoized[$hash] = $result;
    }

    return $object->__memoized[$hash];
}
