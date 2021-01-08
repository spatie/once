<?php

use Spatie\Once\Backtrace;
use Spatie\Once\Cache;
use Spatie\Once\ReflectionCallable;

function once(callable $callback): mixed
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 2
    );

    $backtrace = new Backtrace($trace);

    if ($backtrace->getFunctionName() === 'eval') {
        return call_user_func($callback);
    }

    $reflection = new ReflectionCallable($callback);

    $object = $backtrace->getObject();

    $normalizedArguments = $reflection->getNumberOfParameters()
        ? array_map(
            fn ($argument) => is_object($argument) ? spl_object_hash($argument) : $argument,
            $backtrace->getArguments()
        )
        : null;

    $normalizedStaticVariables = array_map(
        fn ($staticVariable) => is_object($staticVariable) ? spl_object_hash($staticVariable) : $staticVariable,
        $reflection->getStaticVariables()
    );

    $prefix = $backtrace->getFunctionName();

    $hash = hash('sha256', $prefix.'|'.serialize($normalizedArguments).'|'.serialize($normalizedStaticVariables));

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
