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
    return onceGenerics(true, $callback);
}

/**
 * @template T
 *
 * @param (callable(): T)|bool $callback
 * @param (callable(): T) $callback
 * @return T
 */
function onceIf(callable|bool $condition, callable $callback): mixed
{
    return onceGenerics($condition, $callback);
}

/**
 * @template T
 *
 * @param (callable(): T)|bool $callback
 * @param (callable(): T) $callback
 * @return T
 */
function onceGenerics(callable|bool  $condition, callable $callback): mixed
{
    $trace = debug_backtrace(
        DEBUG_BACKTRACE_PROVIDE_OBJECT, 3
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

    $condition = is_callable($condition) ? $condition() : $condition;

    if (! $cache->has($object, $hash) || ! $condition) {
        $result = call_user_func($callback, $backtrace->getArguments());

        $cache->set($object, $hash, $result);
    }

    return $cache->get($object, $hash);
}
