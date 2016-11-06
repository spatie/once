<?php

namespace Spatie\Once;

class Backtrace

{
    /** @var array */
    public $trace;

    public function __construct(array $trace)
    {
        $this->trace = $trace;
    }

    public function getFile()
    {
        return $this->trace['file'];
    }

    public function getLine()
    {
        return $this->trace['line'];
    }

    public function getArguments()
    {
        return $this->trace['args'];
    }

    public function getFunctionName()
    {
        return $this->trace['function'];
    }

    public function getObject()
    {
        return $this->trace['object'];
    }

    public function hasObject()
    {
        return isset($this->trace['object']);
    }

    public function getHash()
    {
        $normalizedArguments = array_map(function($argument) {
            return is_object($argument) ? spl_object_hash($argument) : $argument;
        }, $this->getArguments());

        return md5(serialize($normalizedArguments));
    }
}