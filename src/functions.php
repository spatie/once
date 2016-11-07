<?php

use Spatie\Once\Backtrace;

function once($callback)
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
    )[1];

    $backtrace = new Backtrace($trace);

    if (! $object = $backtrace->getObject()) {
        throw new Exception('Cannot use `once` outside a class');
    }

    $hash = $backtrace->getArgumentHash();

    if (! isset($object->__memoized[$backtrace->getFunctionName()][$hash])) {
        $result = call_user_func($callback, $backtrace->getArguments());

        $object->__memoized[$backtrace->getFunctionName()][$hash] = $result;
    }

    return $object->__memoized[$backtrace->getFunctionName()][$hash];
}
