<?php

namespace Spatie\Once;

class Cache
{
    /** @var array */
    public static $values = [];

    /**
     * Determine if a value exists for a given object / hash.
     *
     * @param  mixed  $object
     * @param  string  $backtraceHash
     *
     * @return bool
     */
    public static function has($object, string $backtraceHash): bool
    {
        $objectHash = spl_object_hash($object);

        if (! isset(static::$values[$objectHash])) {
            return false;
        }

        return array_key_exists($backtraceHash, static::$values[$objectHash]);
    }

    /**
     * Retrieve a value for an object / hash.
     *
     * @param  mixed  $object
     * @param  string  $backtraceHash
     *
     * @return mixed
     */
    public static function get($object, string $backtraceHash)
    {
        return static::$values[spl_object_hash($object)][$backtraceHash];
    }

    /**
     * Set a cached value for an object / hash.
     *
     * @param  mixed  $object
     * @param  string  $backtraceHash
     * @param  mixed  $value
     */
    public static function set($object, string $backtraceHash, $value)
    {
        static::$values[spl_object_hash($object)][$backtraceHash] = $value;
    }
}
