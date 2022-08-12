<?php

use Spatie\Once\Backtrace;
use Spatie\Once\Cache;

/**
 * @template T
 *
 * @param (callable(): T) $callback
 * @return T
 */
function once(callable $callback): mixed
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

    $cache = Cache::getInstance();

    if (is_string($object)) {
        $object = $cache;
    }

    if (! $cache->isEnabled()) {
        return call_user_func($callback, $backtrace->getArguments());
    }

    if (! $cache->has($object, $hash)) {
        $result = call_user_func($callback, $backtrace->getArguments());

        $cache->set($object, $hash, $result);
    }

    return $cache->get($object, $hash);
}
