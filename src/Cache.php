<?php

namespace Spatie\Once;

class Cache
{
    /** @var array */
    public static $values = [];

    /** @var bool */
    protected static $enabled = true;

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
        $objectHash = static::objectHash($object);

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
        return static::$values[static::objectHash($object)][$backtraceHash];
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
        static::addDestroyListener($object);

        static::$values[static::objectHash($object)][$backtraceHash] = $value;
    }

    /**
     * Forget the stored items for the given objectHash.
     *
     * @param string $objectHash
     */
    public static function forget(string $objectHash)
    {
        unset(static::$values[$objectHash]);
    }

    /**
     * Flush the entire cache.
     */
    public static function flush()
    {
        static::$values = [];
    }

    protected static function objectHash($object): string
    {
        return is_string($object) ? $object : spl_object_hash($object);
    }

    protected static function addDestroyListener($object)
    {
        if (is_string($object)) {
            return;
        }

        $randomPropertyName = '___once_listener__'.rand(1, 1000000);

        if (isset($object->$randomPropertyName)) {
            return;
        }

        $object->$randomPropertyName = new Listener($object);
    }

    public static function disable()
    {
        static::$enabled = false;
    }

    public static function enable()
    {
        static::$enabled = true;
    }

    public static function isEnabled(): bool
    {
        return static::$enabled;
    }
}
