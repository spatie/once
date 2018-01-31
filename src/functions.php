<?php

use Spatie\Once\Cache;
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

    if (! Cache::has($object, $hash)) {
        $result = call_user_func($callback, $backtrace->getArguments());

        Cache::set($object, $hash, $result);
    }

    return Cache::get($object, $hash);
}
