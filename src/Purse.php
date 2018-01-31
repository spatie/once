<?php

namespace Spatie\Once;

class Purse
{
    /**
     * The cached values.
     *
     * @var array
     */
    public static $values = [];

    /**
     * Determine if a value exists for a given object / hash.
     *
     * @param  mixed  $object
     * @param  string  $hash
     * @return bool
     */
    public static function has($object, string $hash): bool
    {
        $mainHash = spl_object_hash($object);

        return isset(static::$values[$mainHash]) &&
               array_key_exists($hash, static::$values[$mainHash]);
    }

    /**
     * Retrieve a value for an object / hash.
     *
     * @param  mixed  $object
     * @param  string  $hash
     * @return mixed
     */
    public static function get($object, string $hash)
    {
        return static::$values[spl_object_hash($object)][$hash];
    }

    /**
     * Set a cached value for an object / hash.
     *
     * @param  mixed  $object
     * @param  string  $hash
     * @param  mixed  $value
     * @return void
     */
    public static function set($object, string $hash, $value)
    {
        static::$values[spl_object_hash($object)][$hash] = $value;
    }
}
