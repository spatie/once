<?php

namespace Spatie\Once;

class Listener
{
    /** @var bool */
    private $hasBeenSerialized = false;

    public function __construct($object)
    {
        $this->objectHash = spl_object_hash($object);
    }

    public function __destruct()
    {
        if (! $this->hasBeenSerialized) {
            Cache::forget($this->objectHash);
        }
    }

    public function __wakeup()
    {
        $this->hasBeenSerialized = true;
    }
}
