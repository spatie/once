<?php

use Spatie\Once\Backtrace;

function once($callback)
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
    )[1];

    $backtrace = new Backtrace($trace);


    if (! $backtrace->hasObject()) {

        static $memoized;

        $trace = debug_backtrace(
            DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
        )[0];

        $backtrace = new Backtrace($trace);

        $hash = $backtrace->getFile() . $backtrace->getLine();

        if (! isset($memoized[$hash])) {
            $memoized[$hash] = call_user_func($callback, $backtrace->getArguments());
        }

        return $memoized[$hash];
    }

    $object = $backtrace->getObject();

    $hash = $backtrace->getHash();

    if (! isset($object->__memoized[$backtrace->getFunctionName()][$hash])) {
        $result = call_user_func($callback, $backtrace->getArguments());

        $object->__memoized[$backtrace->getFunctionName()][$hash] = $result;
    }

    return $object->__memoized[$backtrace->getFunctionName()][$hash];
}