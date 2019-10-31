<?php

use Spatie\Once\Cache;
use Spatie\Once\Backtrace;

function once($callback)
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
    );

    $backtrace = new Backtrace($trace);

    if ($backtrace->getFunctionName() === 'eval') {
        return call_user_func($callback);
    }

    $object = $backtrace->getObject();

    $hash = $backtrace->getHash();

    if (! Cache::isEnabled()) {
        return call_user_func($callback, $backtrace->getArguments());
    }

    if (! Cache::has($object, $hash)) {
        $result = call_user_func($callback, $backtrace->getArguments());

        Cache::set($object, $hash, $result);
    }

    return Cache::get($object, $hash);
}
